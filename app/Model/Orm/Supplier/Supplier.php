<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * Supplier
 * @property int $id {primary}
 * @property string $name
 * @property string $code {enum self::CODE_*}
 * @property \DateTimeImmutable $createdAt
 * @property bool $deleted
 * @property SupplierProduct[]|OneHasMany $supplierProducts {1:m SupplierProduct::$supplier}
 */
class Supplier extends Entity
{
    public const CODE_NOVIKO = "NOVIKO";
}
