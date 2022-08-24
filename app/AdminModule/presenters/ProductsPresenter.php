<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Datagrids\ProductsDatagrid;
use App\AdminModule\Components\ProductsDatagridFactory;
use App\AdminModule\Forms\AssignMarketProductForm;
use App\AdminModule\Forms\IAssignMarketProductFormFactory;
use App\Model\Product;
use Tracy\Debugger;

class ProductsPresenter extends BaseAppPresenter
{
    /** @inject */
    public IAssignMarketProductFormFactory $assignMarketProductFormFactory;

    /** @inject */
    public ProductsDatagridFactory $productsDatagridFactory;

    public Product $product;

    public function renderDefault(): void
    {
    }

    public function actionDetail(int $id): void
    {
        /** @var Product|null $product */
        $product = $this->orm->products->getById($id);
        if ($product == null) {
            throw new \Exception("Product with id " . $id . " not found");
        }
        $this->product = $product;
    }

    public function renderDetail(): void
    {
        $this->getTemplate()->product = $this->product;
        $assignedMarkets = [];
        if ($this->product->stockItem) {
            foreach ($this->product->stockItem->marketProducts as $marketProduct) {
                $assignedMarkets[$marketProduct->market->id] = $marketProduct;
            }
        }
        $this->getTemplate()->assignedMarkets = $assignedMarkets;
    }

    public function createComponentProductsDatagrid(string $name): ProductsDatagrid
    {
        return $this->productsDatagridFactory->create($this);
    }

    public function createComponentAssignMarketProductForm(): AssignMarketProductForm
    {
        return $this->assignMarketProductFormFactory->create($this->product);
    }
}