<?php

namespace App\Model;

use Nextras\Dbal\Result\Result;
use Nextras\Orm\Repository\Repository;

/**
 * @method Result|null getStockChanges(int $id)
 * @method Result|null getStockChangesDaily(int $id, \DateTimeImmutable $from, \DateTimeImmutable $to)
 */
class SupplierProductsRepository extends Repository{

    /**
     * Returns possible entity class names for current repository.
     * @return string[]
     */
    public static function getEntityClassNames(): array
    {
        return [SupplierProduct::Class];
    }
}