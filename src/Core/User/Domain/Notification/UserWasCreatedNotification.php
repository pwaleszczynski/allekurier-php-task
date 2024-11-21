<?php

declare(strict_types=1);

namespace App\Core\User\Domain\Notification;

use App\Core\User\Domain\ValueObject\Email;

interface UserWasCreatedNotification
{
    public function send(Email $email): void;
}
