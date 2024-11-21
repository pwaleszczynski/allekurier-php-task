<?php

declare(strict_types=1);

namespace App\Core\User\Application\EventListener;

use App\Core\User\Domain\Event\UserWasCreatedEvent;
use App\Core\User\Domain\Notification\UserWasCreatedNotification;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class SendEmailUserWasCreatedEventListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly UserWasCreatedNotification $notification,
    ) {
    }

    public function send(UserWasCreatedEvent $event): void
    {
        $this->notification->send($event->email);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserWasCreatedEvent::class => 'send'
        ];
    }
}
