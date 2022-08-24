<?php

namespace App\Model;

use Nextras\Orm\Repository\Repository;

class ProductsRepository extends Repository{

    /**
     * Returns possible entity class names for current repository.
     * @return string[]
     */
    public static function getEntityClassNames(): array
    {
        return [Product::Class];
    }
}