<?php

namespace PlumeSolution\Async\Bus\Query;

interface QueryBus
{
    function ask(Query $query): mixed;
}
