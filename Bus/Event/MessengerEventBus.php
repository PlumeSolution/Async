<?php

namespace PlumeSolution\Async\Bus\Event;

use Symfony\Component\Messenger\MessageBusInterface;

class MessengerEventBus implements EventBus
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $eventBus;

    public function __construct(MessageBusInterface $eventBus)
    {
        $this->eventBus = $eventBus;
    }

    public function dispatch(Event $event): void
    {
        $this->eventBus->dispatch($event);
    }
}
