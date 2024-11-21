<?php

declare(strict_types=1);

namespace App\Common\EventManager;

use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

abstract class DoctrineEventsCollectorRepository
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
        protected readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function store(EventsCollectorInterface $eventsCollector): void
    {
        $this->entityManager->persist($eventsCollector);

        $events = $eventsCollector->pullEvents();

        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
