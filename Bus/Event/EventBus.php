<?php

namespace PlumeSolution\Async\Bus\Event;

interface EventBus
{
    public function dispatch(Event $event): void;
}
