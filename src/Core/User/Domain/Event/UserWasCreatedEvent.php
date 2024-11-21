<?php

declare(strict_types=1);

namespace App\Core\User\Domain\Event;

use App\Common\EventManager\EventInterface;
use App\Core\User\Domain\ValueObject\Email;

final class UserWasCreatedEvent implements EventInterface
{
    public function __construct(
        public readonly Email $email,
    ) {
    }
}