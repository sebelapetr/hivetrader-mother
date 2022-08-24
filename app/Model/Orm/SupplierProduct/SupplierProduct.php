<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;

/**
 * SupplierProduct
 * @property int $id {primary}
 * @property string $supplierInternalId
 * @property string $ean
 * @property string $name
 * @property \DateTimeImmutable $createdAt
 * @property \DateTimeImmutable $updatedAt
 * @property Supplier $supplier {m:1 Supplier::$supplierProducts}
 * @property Product|null $product {m:1 Product::$supplierProducts}
 */
class SupplierProduct extends Entity
{

}
