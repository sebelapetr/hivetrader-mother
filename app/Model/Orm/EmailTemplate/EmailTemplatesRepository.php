<?php

namespace App\Model;

use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Repository\Repository;

/**
 * Class EmailTemplatesRepository
 * @package App\Model
 *
 */

class EmailTemplatesRepository extends Repository{

    /**
     * Returns possible entity class names for current repository.
     * @return string[]
     */
    public static function getEntityClassNames(): array
    {
        return [EmailTemplate::class];
    }
}