<?php

namespace App\Model;

use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Repository\Repository;

/**
 * Class OrdersRepository
 * @package App\Model
 *
 */

class OrdersRepository extends Repository{

    /**
     * Returns possible entity class names for current repository.
     * @return string[]
     */
    public static function getEntityClassNames(): array
    {
        return [Order::class];
    }

    public function findNewOrders(): ICollection
    {
        return $this->findBy([
           "state" => Order::STATE_NEW
        ])->orderBy("sentAt", "ASC");
    }

    public function findNotCompletedOrders(): ICollection
    {
        return $this->findBy([
            "state" => [
                Order::STATE_CONFIRMED,
                Order::STATE_PROCESSING,
                Order::STATE_WAITING_FOR_DELIVERY,
                Order::STATE_WAITING_FOR_PICKUP
            ]
        ])->orderBy("sentAt", "ASC");
    }

    public function findCompletedOrders(): ICollection
    {
        return $this->findBy([
            "state" => [
                Order::STATE_COMPLETED,
                Order::STATE_STORNO,
                Order::STATE_RETURNED
            ]
        ])->orderBy("sentAt", "ASC");
    }

}