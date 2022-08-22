<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;

/**
 * SupplierProduct
 * @property int $id {primary}
 * @property string $supplierInternalId
 /* @property Product $product
 /* @property ProductBrand $productBrand
/ * @property price...
 * @property string $ean
 * @property string $name
 * @property \DateTimeImmutable $createdAt
 * @property \DateTimeImmutable $updatedAt
 * @property Supplier $supplier {m:1 Supplier::$supplierProducts}
 */
class SupplierProduct extends Entity
{

}
