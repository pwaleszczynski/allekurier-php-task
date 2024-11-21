<?php

declare(strict_types=1);

namespace App\Core\User\Infrastructure\Notification;

use App\Common\Mailer\MailerInterface;
use App\Core\User\Domain\Notification\UserWasCreatedNotification;
use App\Core\User\Domain\ValueObject\Email;

class UserWasCreatedEmailNotification implements UserWasCreatedNotification
{
    public function __construct(
        private readonly MailerInterface $mailer,
    ) {
    }

    public function send(Email $email): void
    {
        $this->mailer->send(
            $email->get(),
            'Zarejestrowano konto w systemie',
            'Aktywacja konta trwa do 24h',
        );
    }
}
