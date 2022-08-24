<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * Class StockItem
 * @package App\Model
 * @property int $id {primary}
 * @property int $quantity
 * @property DateTimeImmutable $createdAt
 * @property DateTimeImmutable $updatedAt
 * @property Stock $stock {m:1 Stock::$stockItems}
 * @property Product $product {1:1 Product::$stockItem, isMain=true}
 * @property MarketProduct[]|OneHasMany $marketProducts {1:m MarketProduct::$stockItem}
 */
class StockItem extends Entity
{
}