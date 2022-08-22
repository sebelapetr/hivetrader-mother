<?php

namespace App\Model;

use Nextras\Dbal\Result\Result;
use Nextras\Orm\Repository\Repository;

class SuppliersRepository extends Repository{

    /**
     * Returns possible entity class names for current repository.
     * @return string[]
     */
    public static function getEntityClassNames(): array
    {
        return [Supplier::Class];
    }
}