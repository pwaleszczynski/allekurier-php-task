<?php

namespace App\Core\User\Infrastructure\Persistance;

use App\Common\EventManager\DoctrineEventsCollectorRepository;
use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\Status\UserActivityStatus;
use App\Core\User\Domain\User;
use App\Core\User\Domain\ValueObject\Email;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Psr\EventDispatcher\EventDispatcherInterface;

class DoctrineUserRepository extends DoctrineEventsCollectorRepository implements UserRepositoryInterface
{
    public function __construct(
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher,
    ) {
        parent::__construct($entityManager, $eventDispatcher);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getByEmail(Email $email): User
    {
        $user = $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :user_email')
            ->setParameter(':user_email', $email->get())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $user) {
            throw new UserNotFoundException('Użytkownik nie istnieje');
        }

        return $user;
    }

    public function save(User $user): void
    {
        $this->store($user);
    }

    public function getEmailsByActivityStatus(UserActivityStatus $activityStatus): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        return $queryBuilder
            ->select('u.email')
            ->from(User::class, 'u')
            ->andWhere('u.activityStatus = :activityStatus')
            ->setParameter('activityStatus', $activityStatus)
            ->getQuery()
            ->getArrayResult();
    }
}
