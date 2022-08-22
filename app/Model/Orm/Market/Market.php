<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;
use Nextras\Orm\Relationships\OneHasOne;

/**
 * Class Market
 * @package App\Model
 * @property int $id {primary}
 * @property string $name
 * @property string $code {enum self::CODE_*}
 * @property string $url
 * @property DateTimeImmutable $createdAt
 * @property Order[]|OneHasMany $orders {1:m Order::$market}
 */
Class Market extends Entity
{
   public const CODE_TEST = "TEST";
}