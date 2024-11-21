<?php

declare(strict_types=1);

namespace App\Core\User\Domain\ValueObject;

use App\Core\User\Domain\Exception\UserException;
use Stringable;

final class Email implements Stringable
{
    private function __construct(
        private readonly string $email,
    ) {
    }

    public static function fromString(string $email): self
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new UserException('Invalid user email');
        }

        return new self($email);
    }

    public function get(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}
