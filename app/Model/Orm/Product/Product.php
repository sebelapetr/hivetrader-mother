<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * Product
 * @property int $id {primary}
 * @property string $name
 * @property string $ean
 * @property string $priceWithVatMin
 * @property string $priceWithVatMax
 * @property int $totalPurchased
 * @property int $totalSale
 * @property string $totalProfit
 * @property string $totalProfitPercent
 * @property int $stockQuantity {virtual}
 * @property int $activeMarkets {virtual}
 * @property \DateTimeImmutable $createdAt
 * @property \DateTimeImmutable $updatedAt
 * @property bool $deleted
 * @property Supplier $supplier {m:1 Supplier::$supplierProducts}
 * @property SupplierProduct[]|OneHasMany $supplierProducts {1:m SupplierProduct::$product}
 * @property StockItem|NULL $stockItem {1:1 StockItem::$product}
// * @property ProductBrand
// * @property ProductSuppliers[]
 */
class Product extends Entity
{
    public function getterStockQuantity(): int
    {
        return 1; //by stock
    }

    public function getterActiveMarkets(): int
    {
        return 1; //return number on how many markets is assigned and active
    }
}
