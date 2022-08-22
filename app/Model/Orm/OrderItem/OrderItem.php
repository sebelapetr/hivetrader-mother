<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;

/**
 * Class OrderItem
 * @package App\Model
 * @property int $id {primary}
 * @property string $type {enum self::TYPE_*}
 * @property string $number
 * @property string $name
 * @property float $pricePiece
 * @property float $pricePieceVat
 * @property float $price
 * @property float $priceVat
 * @property int $quantity
 * @property int $vat
 * @property DateTimeImmutable|NULL $createdAt
 * @property Order|NULL $order {m:1 Order::$orderItems}

 */
class OrderItem extends Entity
{
    public const TYPE_SHIPPING = "SHIPPING";
    public const TYPE_PAYMENT = "PAYMENT";
    public const TYPE_PRODUCT = "PRODUCT";
}