<?php

namespace PlumeSolution\Async\Factory;

use PlumeSolution\Async\Managers\Async\EventLoopManager;
use React\EventLoop\LoopInterface;

class EventLoopFactory
{
	/**
	 * @param EventLoopManager $manager
	 * @return LoopInterface
	 */
	public static function getEventLoop(EventLoopManager $manager)
	{
		return $manager->getLoop();
	}
}