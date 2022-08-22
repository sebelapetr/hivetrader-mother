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
use Nette\Application\UI\Form;
use Nextras\Orm\Collection\ICollection;
use Tracy\Debugger;

class SupplierProductsPresenter extends BaseAppPresenter
{
    /** @inject */
    public SupplierProductsDatagridFactory $supplierProductsDatagridFactory;

    public ?Supplier $supplier;

    public function actionDefault(int $id = null): void
    {
        if ($id !== null) {
            $supplier = $this->orm->suppliers->getBy(["id" => $id, "deleted" => false]);
            if ($supplier) {
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

    public function createComponentSupplierProductsDatagrid(string $name): SupplierProductsDatagrid
    {
        return $this->supplierProductsDatagridFactory->create($this, $this->supplier);
    }
}