<?php

declare(strict_types=1);

namespace App\Core\User\Infrastructure\Repository;

use App\Core\User\Domain\Repository\CheckUserEmailRepositoryInterface;
use App\Core\User\Domain\User;
use App\Core\User\Domain\ValueObject\Email;
use Doctrine\ORM\EntityManagerInterface;

class CheckUserEmailRepository implements CheckUserEmailRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function exists(Email $email): bool
    {
        $result = $this->entityManager->createQueryBuilder('u')
            ->select('count(u.id)')
            ->from(User::class, 'u')
            ->where('u.email = :user_email')
            ->setParameter(':user_email', $email->get())
            ->getQuery()
            ->getSingleScalarResult();

        return $result > 0;
    }
}
