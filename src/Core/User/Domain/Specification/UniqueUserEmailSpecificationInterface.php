<?php

declare(strict_types=1);

namespace App\Core\User\Domain\Specification;

use App\Core\User\Domain\Exception\UserEmailAlreadyExistsException;
use App\Core\User\Domain\ValueObject\Email;

interface UniqueUserEmailSpecificationInterface
{
    /**
     * @throws UserEmailAlreadyExistsException
     */
    public function isUnique(Email $email): bool;
}
