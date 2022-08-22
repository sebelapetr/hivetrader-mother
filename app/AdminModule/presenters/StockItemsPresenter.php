<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Datagrids\StockItemsDatagrid;
use App\AdminModule\Components\StockItemsDatagridFactory;
use App\Model\Role;
use Nextras\Orm\Collection\ICollection;

class StockItemsPresenter extends BaseAppPresenter
{
    /** @inject */
    public StockItemsDatagridFactory $stockItemsDatagridFactory;

    public function actionDefault(): void
    {
    }

    public function actionDetail(): void
    {
    }

    public function createComponentStockItemsDatagrid(string $name): StockItemsDatagrid
    {
        return $this->stockItemsDatagridFactory->create($this);
    }
}