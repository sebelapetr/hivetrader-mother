<?php

namespace App\Model;

use Nette\Utils\DateTime;
use Nextras\Dbal\Utils\DateTimeImmutable;
use Nextras\Orm\Entity\Entity;

/**
 * Class Email
 * @package App\Model
 * @property int $id {primary}
 * @property string $subject
 * @property string $senderEmail
 * @property string $senderName
 * @property string $receiverEmail
 * @property string $body
 * @property DateTimeImmutable|NULL $createdAt
 * @property DateTimeImmutable|NULL $sentAt
 * @property bool|NULL $sentSuccess
 * @property string|NULL $error
 * @property EmailTemplate $emailTemplate {m:1 EmailTemplate::$emails}
 * @property Order|NULL $order {m:1 Order::$emails}

 */
class Email extends Entity
{
}