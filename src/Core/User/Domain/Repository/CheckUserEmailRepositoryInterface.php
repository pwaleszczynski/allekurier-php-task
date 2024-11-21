<?php

declare(strict_types=1);

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\ValueObject\Email;

interface CheckUserEmailRepositoryInterface
{
    public function exists(Email $email): bool;
}
