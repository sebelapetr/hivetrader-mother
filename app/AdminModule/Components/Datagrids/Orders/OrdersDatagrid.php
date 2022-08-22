<?php
declare(strict_types=1);

namespace App\AdminModule\Components\Datagrids;

use App\Model\Orm;
use App\Model\Order;
use Contributte\Translation\Translator;
use Nette;

class OrdersDatagrid extends BasicDatagrid
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
        $this->setDataSource($this->orm->orders->findAll()->orderBy("createdAt", "DESC"));

        $this->setColumnsHideable();

        $this->addColumnText('id', $this->translator->translate($this->langDomain.'.id'))
            ->setSortable()
            ->setFilterText();

        $this->addColumnText('number', $this->translator->translate($this->langDomain.'.number'))
            ->setSortable()
            ->setFilterText();

        $this->addColumnText("sentAt", $this->translator->translate($this->langDomain.'.sentAt'))
            ->setRenderer(function (Order $item) {
                return $item->sentAt->format('d.m.Y H:i');
            })
            ->setSortable()
            ->setFilterDate();

        $this->addColumnText('market', $this->translator->translate($this->langDomain.'.market'))
            ->setRenderer(function (Order $order) {
                return $order->market->name;
            });

        $this->addColumnText("name", $this->translator->translate($this->langDomain.'.name'))
            ->setRenderer(function (Order $order) {
                return $order->name . ' ' . $order->surname;
            });

        $this->addColumnText("totalPriceVat", $this->translator->translate($this->langDomain.'.totalPriceVat'))
            ->setSortable()
            ->setFilterText();

        $this->addColumnText("state", $this->translator->translate($this->langDomain.'.state'))
            ->setRenderer(function(Order $order) {
                return "todo";
            })
            ->setSortable()
            ->setFilterSelect([
            ])->setPrompt('');

        $this->addAction('detail', $this->translator->translate($this->langDomain.'.detail'))
            ->setClass('btn btn-success btn-sm');
    }
}