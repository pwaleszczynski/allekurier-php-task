<?php

declare(strict_types=1);

namespace App\Core\User\Domain\Status;

enum UserActivityStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function equals(self $userActivityStatus): bool
    {
        return $this->value  === $userActivityStatus->value;
    }
}
