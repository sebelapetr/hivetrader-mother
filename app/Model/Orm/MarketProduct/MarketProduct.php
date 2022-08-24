<?php

namespace App\Model;

use Nextras\Orm\Entity\Entity;
use Nextras\Orm\Relationships\OneHasMany;

/**
 * MarketProduct
 * @property int $id {primary}
 * @property string $name
 * @property string $number
 * @property int $saleQuantity {virtual}
 * @property float $priceWithoutVat
 * @property float $priceWithVat
 * @property int $vat
 * @property \DateTimeImmutable $createdAt
 * @property \DateTimeImmutable $updatedAt
 * @property bool $active
 * @property bool $deleted
 * @property Market $market {m:1 Market::$marketProducts}
 * @property StockItem $stockItem {m:1 StockItem::$marketProducts}
 */
class MarketProduct extends Entity
{
    public function getterSaleQuantity(): int
    {
        /** @var MarketProductsRepository $repository */
        $repository = $this->getRepository();
        return $repository->getSaleQuantity($this->id);
    }
}
