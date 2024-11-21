<?php

declare(strict_types=1);

namespace App\Common\EventManager;

interface EventsCollectorInterface
{
    /**
     * @return EventInterface[]
     */
    public function getEvents(): array;
}
