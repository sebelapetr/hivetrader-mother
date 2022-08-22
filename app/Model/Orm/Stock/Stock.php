<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;
use Nextras\Orm\Relationships\OneHasOne;

/**
 * Class Stock
 * @package App\Model
 * @property int $id {primary}
 * @property string $code {enum self::CODE_*}
 * @property DateTimeImmutable $createdAt
 * @property StockItem[]|OneHasMany $stockItems {1:m StockItem::$stock}
 */
Class Stock extends Entity
{
    public const CODE_DOMA = "DOMA";
    public const CODE_NOVIKO = "NOVIKO";
}