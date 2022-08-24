<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;

/**
 * Class OrderStateChange
 * @package App\Model
 * @property int $id {primary}
 * @property Order $order {m:1 Order::$orderStateChanges}
 * @property string $state {enum Order::STATE_*}
 * @property DateTimeImmutable $createdAt {default now}
 * @property User|null $createdBy {m:1 User::$orderStateChanges}
 */
Class OrderStateChange extends Entity
{
}