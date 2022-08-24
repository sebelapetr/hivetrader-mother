<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Datagrids;

use App\Model\DeliveryType;
use App\Model\Enum\FlashMessages;
use App\Model\OrderState;
use App\Model\Orm;
use App\Model\Order;
use App\Model\PaymentType;
use App\Model\Product;
use App\Model\Role;
use App\Model\StockItem;
use App\Model\Supplier;
use App\Model\SupplierProduct;
use App\Model\User;
use Nette;
use Nette\Utils\Html;

class ProductsDatagrid extends BasicDatagrid
{
    protected Orm $orm;
    protected Nette\Application\UI\Presenter $presenter;

    public function __construct(Orm $orm, Nette\Application\UI\Presenter $presenter, Nette\ComponentModel\IContainer $parent = null, string $name = null)
    {
        parent::__construct($orm, $parent, $name);
        $this->orm = $orm;
        $this->presenter = $presenter;
    }

    public function setup(): void
    {
        $this->setDataSource($this->orm->products->findAll()->orderBy("createdAt", "DESC"));

        $this->addColumnText('name', $this->translator->translate($this->langDomain.'.name'))
            ->setSortable()
            ->setFilterText();

        $this->addColumnText("ean", $this->translator->translate($this->langDomain.'.ean'))
            ->setSortable()
            ->setFilterDate();

        $this->addColumnText("createdAt", $this->translator->translate($this->langDomain.'.createdAt'))
            ->setRenderer(function (Product $product) {
                return $product->createdAt->format('d.m.Y H:i');
            })
            ->setSortable()
            ->setFilterDate();

        $this->addColumnText("updatedAt", $this->translator->translate($this->langDomain.'.updatedAt'))
            ->setRenderer(function (Product $product) {
                return $product->updatedAt->format('d.m.Y H:i');
            })
            ->setSortable()
            ->setFilterDate();

        $this->addAction('detail', $this->translator->translate($this->langDomain.'.detail'))
            ->setClass('btn btn-outline-default btn-rounded width-100');
    }
}