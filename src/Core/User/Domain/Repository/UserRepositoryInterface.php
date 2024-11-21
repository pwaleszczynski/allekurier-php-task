<?php

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Status\UserActivityStatus;
use App\Core\User\Domain\User;
use App\Core\User\Domain\ValueObject\Email;

interface UserRepositoryInterface
{
    /**
     * @throws UserNotFoundException
     */
    public function getByEmail(Email $email): User;

    /**
     * @return string[]
     */
    public function getEmailsByActivityStatus(UserActivityStatus $activityStatus): array;

    public function save(User $user): void;

    public function flush();
}
