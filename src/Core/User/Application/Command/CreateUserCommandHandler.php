<?php

declare(strict_types=1);

namespace App\Core\User\Application\Command;

use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\Specification\UniqueUserEmailSpecificationInterface;
use App\Core\User\Domain\User;
use App\Core\User\Domain\ValueObject\Email;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserCommandHandler
{
    public function __construct(
        private readonly UniqueUserEmailSpecificationInterface $uniqueUserEmailSpecification,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $email = Email::fromString($command->email);
        $user = User::create($email, $this->uniqueUserEmailSpecification);

        $this->userRepository->save($user);
        $this->userRepository->flush();
    }
}
