<?php

declare(strict_types=1);

namespace App\Core\User\Application\Command;

final class CreateUserCommand
{
    public function __construct(
        public readonly string $email,
    ) {
    }
}
