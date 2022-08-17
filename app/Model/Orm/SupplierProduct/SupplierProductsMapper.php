<?php

namespace App\Model;

use Nextras\Dbal\Result\Result;
use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Mapper\Mapper;

class SupplierProductsMapper extends Mapper
{

    public function getStockChanges(int $supplierProductId): ?Result
    {
        $sql = 'SELECT difference,actual_quantity,created_at FROM  `supplier_product_stock_changes` WHERE `supplier_product_id` = %i ORDER BY created_at ASC';
        return $this->connection->query($sql, $supplierProductId);
    }

    public function getStockChangesDaily(int $supplierProductId, \DateTimeImmutable $from, \DateTimeImmutable $to): ?Result
    {
        $sql = 'SELECT min_stock_level,created_at FROM  `supplier_product_history` WHERE `supplier_product_id` = %i AND created_at >= %dt && created_at <= %dt ORDER BY created_at ASC';
        return $this->connection->query($sql, $supplierProductId, $from, $to);
    }
    
}