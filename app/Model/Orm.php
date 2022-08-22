<?php

namespace App\Model;

use Nextras\Orm\Model\Model;

/**
 * Model
 * @property-read UsersRepository $users
 * @property-read RolesRepository $roles
 * @property-read ActionsRepository $actions
 * @property-read RightsRepository $rights
 *
 * @property-read MarketsRepository $markets
 * @property-read OrdersRepository $orders
 * @property-read OrderItemsRepository $orderItems
 * @property-read StocksRepository $stocks
 * @property-read StockItemsRepository $stockItems
 * @property-read SuppliersRepository $suppliers
 * @property-read SupplierProductsRepository $supplierProducts
 */
class Orm extends Model
{

}