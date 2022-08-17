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
        /** @var SupplierProduct|null $supplierProduct */
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
            $from = \DateTimeImmutable::createFromFormat("Y-m-d", $_GET["from"]);
            if ($from == false) {
                throw new \Exception("Bad date from format");
            }
            $from = $from->setTime(0,0,0);
            $to = \DateTimeImmutable::createFromFormat("Y-m-d", $_GET["to"]);
            if ($to == false) {
                throw new \Exception("Bad date to format");
            }
            $to = $to->setTime(23,59,59);
            $stockChangesDailyData = $this->getStockChangesChartDailyData($this->supplierProduct->id, $from, $to);
        }
        $this->getTemplate()->stockChangesDailyData = $stockChangesDailyData;
    }

    /**
     * @param int $id
     * @return array<string, int>
     */
    private function getStockChangesChartData(int $id): array
    {
        $stockChangesData = [];
        $stockChanges = $this->orm->supplierProducts->getStockChanges($id);
        if ($stockChanges !== null) {
            foreach ($stockChanges as $stockChange) {
                /** @var \DateTimeImmutable $createdAt */
                $createdAt = $stockChange->created_at;
                $stockChangesData[$createdAt->format('d.m.Y H:i:s')] = intval($stockChange->actual_quantity);
            }
        }
        return $stockChangesData;
    }

    /**
     * @param int $id
     * @return array<string, int>
     */
    private function getStockChangesChartDailyData(int $id, \DateTimeImmutable $from, \DateTimeImmutable $to): array
    {
        $stockChangesData = [];
        $stockChanges = $this->orm->supplierProducts->getStockChangesDaily($id, $from, $to);
        if ($stockChanges !== null) {
            foreach ($stockChanges as $stockChange) {
                /** @var \DateTimeImmutable $createdAt */
                $createdAt = $stockChange->created_at;
                $stockChangesData[$createdAt->format('d.m.Y H:i:s')] = intval($stockChange->min_stock_level);
            }
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