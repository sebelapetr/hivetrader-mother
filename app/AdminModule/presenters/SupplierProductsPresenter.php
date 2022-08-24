<?php
/**
 * Created by PhpStorm.
 * User: Petr Šebela
 * Date: 21. 9. 2020
 * Time: 23:32
 */

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Datagrids\SupplierProductsDatagrid;
use App\AdminModule\Components\SupplierProductsDatagridFactory;
use App\Model\Role;
use App\Model\Supplier;
use App\Model\SupplierProduct;
use Nette\Application\UI\Form;
use Nextras\Orm\Collection\ICollection;
use Tracy\Debugger;

class SupplierProductsPresenter extends BaseAppPresenter
{
    /** @inject */
    public SupplierProductsDatagridFactory $supplierProductsDatagridFactory;

    public ?Supplier $supplier;

    public SupplierProduct $supplierProduct;


    public function actionDefault(int $id = null): void
    {
        if ($id !== null) {
            /** @var Supplier|null $supplier */
            $supplier = $this->orm->suppliers->getBy(["id" => $id, "deleted" => false]);
            if ($supplier !== null) {
                $this->supplier = $supplier;
            }
        } else {
            $this->supplier = null;
        }
    }

    public function renderDefault(): void
    {
        $this->getTemplate()->supplier = $this->supplier;
    }

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

    public function createComponentSelectSupplierForm(): Form
    {
        $langDomain = "forms.SelectSupplierForm";

        $form = new Form();
        $form->addSelect("supplier", $this->translator->translate($langDomain.".supplier"), $this->orm->suppliers->findBy(["deleted" => false])->fetchPairs("id", "name"))
            ->setPrompt("")
            ->setDefaultValue($this->supplier !== null ? $this->supplier->id : null);
        $form->addSubmit("submit", $this->translator->translate($langDomain.".submit"));
        $form->onSuccess[] = function(Form $form) {
            $this->redirect("this", ["id" => $form->values->supplier]);
        };
        return $form;
    }


    /**
     * @param int $id
     * @return array<int, int>
     */
    private function getStockChangesChartData(int $id): array
    {
        $stockChangesData = [];
        $stockChanges = $this->orm->supplierProducts->getStockChanges($id);
        if ($stockChanges !== null) {
            foreach ($stockChanges as $stockChange) {
                /** @var \DateTimeImmutable $createdAt */
                $createdAt = $stockChange->created_at;
                $stockChangesData[$createdAt->getTimestamp()*1000] = intval($stockChange->actual_quantity);
            }
        }
        return $stockChangesData;
    }

    /**
     * @param int $id
     * @return array<int, int>
     */
    private function getStockChangesChartDailyData(int $id, \DateTimeImmutable $from, \DateTimeImmutable $to): array
    {
        $stockChangesData = [];
        $stockChanges = $this->orm->supplierProducts->getStockChangesDaily($id, $from, $to);
        if ($stockChanges !== null) {
            foreach ($stockChanges as $stockChange) {
                /** @var \DateTimeImmutable $createdAt */
                $createdAt = $stockChange->created_at;
                $stockChangesData[$createdAt->getTimestamp()*1000] = intval($stockChange->min_stock_level);
            }
        }
        return $stockChangesData;
    }
    public function createComponentDailyChartForm(string $name): Form
    {
        $form = new Form();
        $form->addText("from");
        $form->addText("to");
        $form->onSuccess[] = [$this, "dailyChartFormSuccess"];
        return $form;
    }

    public function dailyChartFormSuccess(Form $form): void
    {
        Debugger::barDump($form->getValues());
    }

    public function createComponentSupplierProductsDatagrid(string $name): SupplierProductsDatagrid
    {
        return $this->supplierProductsDatagridFactory->create($this, $this->supplier); /** @phpstan-ignore-line */
    }
}