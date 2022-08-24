<?php

namespace App\Model;

use Nextras\Dbal\Result\Result;
use Nextras\Orm\Repository\Repository;

/**
 * @method int getSaleQuantity(int $id)
 */
class MarketProductsRepository extends Repository{

    /**
     * Returns possible entity class names for current repository.
     * @return string[]
     */
    public static function getEntityClassNames(): array
    {
        return [MarketProduct::Class];
    }
}