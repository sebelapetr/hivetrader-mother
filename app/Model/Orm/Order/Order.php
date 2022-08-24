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
 * @property Market $market {m:1 Market::$orders}
 * @property string $number #CODE-HASH
 * @property string $hash
 * @property string $state {enum self::STATE_*}
 * @property string|NULL $name
 * @property string|NULL $surname
 * @property string|NULL $telephone
 * @property string|NULL $email
 * @property string|NULL $street
 * @property string|NULL $city
 * @property string|NULL $zip
 * @property string|NULL $note
 * @property string|NULL $company
 * @property string|NULL $ico
 * @property string|NULL $dic
 * @property string|NULL $deliveryName
 * @property string|NULL $deliverySurname
 * @property string|NULL $deliveryCompany
 * @property string|NULL $deliveryStreet
 * @property string|NULL $deliveryCity
 * @property string|NULL $deliveryZip
 * @property float $totalPrice {default 0}
 * @property float $totalPriceVat {default 0}
 * @property DateTimeImmutable $createdAt {default now}
 * @property DateTimeImmutable $sentAt
 * @property DateTimeImmutable $termsAgreeAt
 * @property OrderItem[]|OneHasMany $orderItems {1:m OrderItem::$order}
 * @property OrderStateChange[]|OneHasMany $orderStateChanges {1:m OrderStateChange::$order}
 */
Class Order extends Entity
{
    public const STATE_NEW = "NEW";
    public const STATE_CONFIRMED = "CONFIRMED";
    public const STATE_PROCESSING = "PROCESSING";
    public const STATE_WAITING_FOR_DELIVERY = "WAITING_FOR_DELIVERY";
    public const STATE_WAITING_FOR_PICKUP = "WAITING_FOR_PICKUP";
    public const STATE_COMPLETED = "COMPLETED";
    public const STATE_STORNO = "STORNO";
    public const STATE_RETURNED = "RETURNED";

    public function getAddressString(): string
    {
        return $this->street . ' ' . $this->deliveryStreet . ', ' . $this->deliveryCity . ' ' . $this->deliveryZip;
    }

    public function getShippingOrderItem(): ?OrderItem
    {
        /** @var OrderItem|null $item */
        $item = $this->orderItems->toCollection()->getBy(['type' => OrderItem::TYPE_SHIPPING]);
        return $item;
    }

    public function getPaymentOrderItem(): ?OrderItem
    {
        /** @var OrderItem|null $item */
        $item = $this->orderItems->toCollection()->getBy(['type' => OrderItem::TYPE_PAYMENT]);
        return $item;
    }
}