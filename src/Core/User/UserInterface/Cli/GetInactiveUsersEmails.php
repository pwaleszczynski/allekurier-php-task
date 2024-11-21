<?php

declare(strict_types=1);

namespace App\Core\User\UserInterface\Cli;

use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\Status\UserActivityStatus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:get-inactive-emails',
    description: 'Get emails of inactive users'
)]
class GetInactiveUsersEmails extends Command
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $emails = $this->userRepository->getEmailsByActivityStatus(UserActivityStatus::INACTIVE);

        foreach ($emails as $row) {
            $output->writeln($row['email']);
        }

        return Command::SUCCESS;
    }
}
