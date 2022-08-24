<?php

namespace App\Model;

use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Repository\Repository;

/**
 * Class OrderStateChangesRepository
 * @package App\Model
 *
 */

class OrderStateChangesRepository extends Repository{

    /**
     * Returns possible entity class names for current repository.
     * @return string[]
     */
    public static function getEntityClassNames(): array
    {
        return [OrderStateChange::class];
    }

}