<?php
declare(strict_types=1);

namespace App\AdminModule\Components;

use App\AdminModule\Components\Datagrids\ProductsDatagrid;
use App\AdminModule\Components\Datagrids\SupplierProductsDatagrid;
use App\Model\Orm;
use App\Model\Supplier;
use Contributte\Translation\Translator;
use Nette\Application\UI\Presenter;

class ProductsDatagridFactory
{

    private Translator $translator;

    private Orm $orm;

    public function __construct(Orm $orm, Translator $translator)
    {
        $this->translator = $translator;
        $this->orm = $orm;
    }

    public function create(Presenter $presenter): ProductsDatagrid
    {
        $datagrid = new ProductsDatagrid($this->orm, $presenter);
        $datagrid->setTranslator($this->translator);
        $datagrid->setup();

        return $datagrid;
    }
}