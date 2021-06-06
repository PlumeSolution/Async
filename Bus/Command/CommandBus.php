<?php

namespace PlumeSolution\Async\Bus\Command;

interface CommandBus
{
    function dispatch(Command $command): void;
}
