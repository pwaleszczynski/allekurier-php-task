<?php

namespace App\Core\User\Domain;

use App\Common\EventManager\EventsCollectorInterface;
use App\Common\EventManager\EventsCollectorTrait;
use App\Core\User\Domain\Event\UserWasCreatedEvent;
use App\Core\User\Domain\Specification\UniqueUserEmailSpecificationInterface;
use App\Core\User\Domain\Status\UserActivityStatus;
use App\Core\User\Domain\ValueObject\Email;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements EventsCollectorInterface
{
    use EventsCollectorTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned"=true}, nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="string", length=300, nullable=false, unique=true)
     */
    private string $email;

    /**
     * @ORM\Column(type="string", length=16, nullable=false, enumType="\App\Core\User\Domain\Status\UserActivityStatus")
     */
    private UserActivityStatus $activityStatus;

    private function __construct(
        string $email,
        UserActivityStatus $activityStatus,
    ) {
        $this->id = null;
        $this->email = $email;
        $this->activityStatus = $activityStatus;
    }

    public static function create(
        Email $email,
        UniqueUserEmailSpecificationInterface $uniqueUserEmailSpecification,
    ): self {

        $uniqueUserEmailSpecification->isUnique($email);
        $user = new self($email->get(), UserActivityStatus::INACTIVE);
        $user->record(new UserWasCreatedEvent($email));

        return $user;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function isActive(): bool
    {
        return $this->activityStatus->equals(UserActivityStatus::ACTIVE);
    }
}
