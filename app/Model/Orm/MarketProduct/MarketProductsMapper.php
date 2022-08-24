<?php

namespace App\Model;

use Nextras\Dbal\Result\Result;
use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Mapper\Mapper;

class MarketProductsMapper extends Mapper
{
    public function getSaleQuantity(int $marketProductId): int
    {
        ///todo
        $sql = '
        SELECT SUM(quantity) FROM order_items
        LEFT JOIN orders ON orders.id = order_items.id
        LEFT JOIN markets ON orders.market_id = markets.id
        LEFT JOIN market_products ON market_products.market_id = markets.id
        WHERE market_products.id = %i;
        ';
        $saleQuantity = $this->connection->query($sql, $marketProductId)->fetchField(0);
        return $saleQuantity == NULL ? 0 : $saleQuantity;
    }
}