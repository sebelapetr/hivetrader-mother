<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;
use Nextras\Orm\Relationships\OneHasOne;

/**
 * Class Order
 * @package App\Model
 * @property int $id {primary}
 * @property Market|NULL $market {m:1 Market::$orders}
 * @property string $type {enum self::TYPE_*}
 * @property string $file
 * @property Email[]|OneHasMany $emails {1:m Email::$emailTemplate}
 */
Class EmailTemplate extends Entity
{
    public const TYPE_ORDER_SENT = "ORDER_SENT";
}