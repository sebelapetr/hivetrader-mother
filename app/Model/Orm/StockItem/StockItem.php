<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;

/**
 * Class StockItem
 * @package App\Model
 * @property int $id {primary}
 * @property int $quantity
 * @property DateTimeImmutable $createdAt
 * @property DateTimeImmutable $updatedAt
 * @property Stock $stock {m:1 Stock::$stockItems}

 */
class StockItem extends Entity
{
}