<?php

namespace App\Model;

use Nextras\Orm\Model\Model;

/**
 * Model
 * ----SETTINGS-----
 * @property-read UsersRepository $users
 * @property-read RolesRepository $roles
 * @property-read ActionsRepository $actions
 * @property-read RightsRepository $rights
 *
 * ----STOCK-----
 * @property-read StocksRepository $stocks
 * @property-read StockItemsRepository $stockItems
 *
 * ----PRODUCTS-----
 * @property-read SuppliersRepository $suppliers
 * @property-read SupplierProductsRepository $supplierProducts
 * @property-read ProductsRepository $products
 *
 * ----MARKET-----
 * @property-read MarketsRepository $markets
 * @property-read MarketProductsRepository $marketProducts
 * @property-read OrdersRepository $orders
 * @property-read OrderItemsRepository $orderItems
 * @property-read OrderStateChangesRepository $orderStateChanges
 *
 * @property-read EmailTemplatesRepository $emailTemplates
 * @property-read EmailsRepository $emails
 */
class Orm extends Model
{

}