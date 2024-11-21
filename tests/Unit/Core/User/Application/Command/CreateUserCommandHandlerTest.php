<?php

declare(strict_types=1);

namespace App\Tests\Unit\Core\User\Application\Command;

use App\Core\User\Application\Command\CreateUserCommand;
use App\Core\User\Application\Command\CreateUserCommandHandler;
use App\Core\User\Domain\Exception\UserEmailAlreadyExistsException;
use App\Core\User\Domain\Exception\UserException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\Specification\UniqueUserEmailSpecificationInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateUserCommandHandlerTest extends TestCase
{
    private UserRepositoryInterface|MockObject $userRepository;
    private UniqueUserEmailSpecificationInterface|MockObject $uniqueUserEmailSpecification;
    private CreateUserCommandHandler $commandHandler;

    public function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->uniqueUserEmailSpecification = $this->createMock(UniqueUserEmailSpecificationInterface::class);

        parent::setUp();
    }

    public function test_should_create_user(): void
    {
        $this->userRepository
            ->expects(self::once())
            ->method('save');
        $this->userRepository
            ->expects(self::once())
            ->method('flush');

        $handler = $this->getHandler();

        $handler->__invoke(new CreateUserCommand('test@test.pl'));
    }

    public function test_should_not_create_user_with_invalid_email(): void
    {
        $this->userRepository
            ->expects(self::never())
            ->method('save');
        $this->userRepository
            ->expects(self::never())
            ->method('flush');

        $this->expectException(UserException::class);

        $handler = $this->getHandler();

        $handler->__invoke(new CreateUserCommand('test'));
    }

    public function test_should_not_create_user_with_non_unique_email(): void
    {
        $this->uniqueUserEmailSpecification
            ->method('isUnique')
            ->willThrowException(new UserEmailAlreadyExistsException());
        $this->userRepository
            ->expects(self::never())
            ->method('save');
        $this->userRepository
            ->expects(self::never())
            ->method('flush');

        $handler = $this->getHandler();

        $this->expectException(UserEmailAlreadyExistsException::class);

        $handler->__invoke(new CreateUserCommand('test@test.pl'));
    }

    private function getHandler(): CreateUserCommandHandler
    {
        return new CreateUserCommandHandler($this->uniqueUserEmailSpecification, $this->userRepository);
    }
}