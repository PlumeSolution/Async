<?php

namespace PlumeSolution\Async\Factorys;

use PlumeSolution\Async\Managers\Async\EventLoopManager;
use React\EventLoop\LoopInterface;

class EventLoopFactory
{
	/**
	 * @param EventLoopManager $manager
	 * @return LoopInterface
	 */
	public static function getEventLoop(EventLoopManager $manager): LoopInterface
    {
		return $manager->getLoop();
	}
}
