<?php
/**
 * Created by PhpStorm.
 * User: Petr Šebela
 * Date: 22. 9. 2020
 * Time: 17:22
 */

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\Datagrids\OrdersDatagrid;
use App\AdminModule\Components\OrdersDatagridFactory;
use App\Model\Enum\FlashMessages;
use App\Model\Order;
use App\Model\OrderItem;
use App\Model\Role;
use Tracy\Debugger;

class OrdersPresenter extends BaseAppPresenter
{
    /** @inject */
    public OrdersDatagridFactory $ordersDatagridFactory;

    public Order $order;

    public function createComponentOrdersDatagrid(string $name): OrdersDatagrid
    {
        return $this->ordersDatagridFactory->create($this);
    }


    public function actionDefault(): void
    {
    }

    public function actionDetail(int $id): void
    {
        /** @var Order|null $order */
        $order = $this->orm->orders->getById($id);
        if ($order == null) {
            $this->flashMessage("Order not found");
            $this->redirect("default");
        }
        $this->order = $order;
    }

    public function renderDetail(): void
    {
        $this->getTemplate()->item = $this->order;
    }

}