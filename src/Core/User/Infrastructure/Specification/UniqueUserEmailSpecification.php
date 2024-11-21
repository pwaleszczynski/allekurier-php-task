<?php

declare(strict_types=1);

namespace App\Core\User\Infrastructure\Specification;

use App\Core\User\Domain\Exception\UserEmailAlreadyExistsException;
use App\Core\User\Domain\Repository\CheckUserEmailRepositoryInterface;
use App\Core\User\Domain\Specification\UniqueUserEmailSpecificationInterface;
use App\Core\User\Domain\ValueObject\Email;

final class UniqueUserEmailSpecification implements UniqueUserEmailSpecificationInterface
{
    public function __construct(
        private readonly CheckUserEmailRepositoryInterface $checkUserEmailRepository,
    ) {
    }

    /**
     * @throws UserEmailAlreadyExistsException
     */
    public function isUnique(Email $email): bool
    {
        if ($this->checkUserEmailRepository->exists($email)) {
            throw new UserEmailAlreadyExistsException('User email already exists');
        }

        return true;
    }
}
