<?php
/**
 * Created by PhpStorm.
 * User: Petr Šebela
 * Date: 21. 9. 2020
 * Time: 23:32
 */

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\Model\Role;
use App\Model\SupplierProduct;
use Nette;
use Nextras\Orm\Collection\ICollection;
use Tracy\Debugger;

class StockChangesPresenter extends BaseAppPresenter
{
    public SupplierProduct $supplierProduct;

    public function actionDetail(int $id): void
    {
        $supplierProduct = $this->orm->supplierProducts->getById($id);
        if ($supplierProduct == null) {
            throw new \Exception("Supplier product with id " . $id . " not found");
        }
        $this->supplierProduct = $supplierProduct;
    }

    public function renderDetail(): void
    {
        $this->getTemplate()->supplierProduct = $this->supplierProduct;
        $this->getTemplate()->stockChangesData = $this->getStockChangesChartData($this->supplierProduct->id);
        $stockChangesDailyData = [];
        if (isset($_GET["from"]) && isset($_GET["to"]) && $_GET["from"] !== null && $_GET["to"] !== null) {
            $from = \DateTimeImmutable::createFromFormat("Y-m-d", $_GET["from"])->setTime(0,0,0);
            $to = \DateTimeImmutable::createFromFormat("Y-m-d", $_GET["to"])->setTime(23,59,59);
            $stockChangesDailyData = $this->getStockChangesChartDailyData($this->supplierProduct->id, $from, $to);
        }
        $this->getTemplate()->stockChangesDailyData = $stockChangesDailyData;
    }

    private function getStockChangesChartData(int $id): array
    {
        $stockChangesData = [];
        $stockChanges = $this->orm->supplierProducts->getStockChanges($id);
        foreach ($stockChanges as $stockChange) {
            /** @var \DateTimeImmutable $createdAt */
            $createdAt = $stockChange->created_at;
            $stockChangesData[$createdAt->format('d.m.Y H:i:s')] = $stockChange->actual_quantity;
        }
        return $stockChangesData;
    }

    private function getStockChangesChartDailyData(int $id, \DateTimeImmutable $from, \DateTimeImmutable $to): array
    {
        $stockChangesData = [];
        $stockChanges = $this->orm->supplierProducts->getStockChangesDaily($id, $from, $to);
        foreach ($stockChanges as $stockChange) {
            /** @var \DateTimeImmutable $createdAt */
            $createdAt = $stockChange->created_at;
            $stockChangesData[$createdAt->format('d.m.Y H:i:s')] = $stockChange->min_stock_level;
        }
        return $stockChangesData;
    }
    public function createComponentDailyChartForm(string $name): Nette\Application\UI\Form
    {
        $form = new Nette\Application\UI\Form();
        $form->addText("from");
        $form->addText("to");
        $form->onSuccess[] = [$this, "dailyChartFormSuccess"];
        return $form;
    }

    public function dailyChartFormSuccess(Nette\Application\UI\Form $form): void
    {
        Debugger::barDump($form->getValues());
    }
}