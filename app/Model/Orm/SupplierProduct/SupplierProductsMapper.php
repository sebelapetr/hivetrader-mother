<?php

namespace App\Model;

use Nextras\Dbal\Result\Result;
use Nextras\Orm\Collection\ICollection;
use Nextras\Orm\Mapper\Mapper;

class SupplierProductsMapper extends Mapper
{

    public function getStockChanges(int $supplierProductId): ?Result
    {
        $sql = 'SELECT difference,actual_quantity,created_at FROM  `supplier_product_stock_changes` WHERE `supplier_product_id` = %i';
        return $this->connection->query($sql, $supplierProductId);
    }
    
}