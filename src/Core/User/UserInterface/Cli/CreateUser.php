<?php

declare(strict_types=1);

namespace App\Core\User\UserInterface\Cli;

use App\Core\User\Application\Command\CreateUserCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'New user creation'
)]
class CreateUser extends Command
{
    private const EMAIL_ARGUMENT = 'email';

    public function __construct(private readonly MessageBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bus->dispatch(
            new CreateUserCommand($input->getArgument(self::EMAIL_ARGUMENT)),
        );

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this->addArgument(self::EMAIL_ARGUMENT, InputArgument::REQUIRED);
    }
}
