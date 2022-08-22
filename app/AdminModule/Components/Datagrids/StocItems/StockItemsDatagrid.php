<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Datagrids;

use App\Model\DeliveryType;
use App\Model\Enum\FlashMessages;
use App\Model\OrderState;
use App\Model\Orm;
use App\Model\Order;
use App\Model\PaymentType;
use App\Model\Role;
use App\Model\StockItem;
use App\Model\User;
use Nette;
use Nette\Utils\Html;

class StockItemsDatagrid extends BasicDatagrid
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
        $this->setDataSource($this->orm->stockItems->findAll()->orderBy("createdAt", "DESC"));

        $this->setColumnsHideable();

        $this->addColumnText('id', $this->translator->translate($this->langDomain.'.id'))
            ->setSortable()
            ->setFilterText();

        $this->addColumnText('stock', $this->translator->translate($this->langDomain.'.stock'))
            ->setRenderer(function (StockItem $stockItem) {
                return $stockItem->stock->code;
            });

        $this->addColumnText('quantity', $this->translator->translate($this->langDomain.'.quantity'))
            ->setSortable()
            ->setFilterText();

        $this->addColumnText("createdAt", $this->translator->translate($this->langDomain.'.createdAt'))
            ->setRenderer(function (StockItem $stockItem) {
                return $stockItem->createdAt->format('d.m.Y H:i');
            })
            ->setSortable()
            ->setFilterDate();

        $this->addColumnText("updatedAt", $this->translator->translate($this->langDomain.'.updatedAt'))
            ->setRenderer(function (StockItem $stockItem) {
                return $stockItem->updatedAt->format('d.m.Y H:i');
            })
            ->setSortable()
            ->setFilterDate();

        $this->addAction('detail', $this->translator->translate($this->langDomain.'.detail'))
            ->setClass('btn btn-success btn-sm');
    }
}