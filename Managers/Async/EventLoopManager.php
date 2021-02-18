<?php

namespace PlumeSolution\Async\Managers\Async;

use Exception;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use React\EventLoop\Factory;

/**
 * Class EventLoopManager
 * Manage Event loop simply
 * @package PlumeSolution\Async\Managers\Async
 */
class EventLoopManager
{
	/**
	 * @var LoopInterface
	 */
	private LoopInterface $loop;

	/**
	 * @var TimerInterface[]
	 */
	private array $timers;

	/**
	 * @var TimerInterface[]
	 */
	private array $periodicTimers;

	/**
	 * @return LoopInterface
	 * @throws Exception
	 */
	public function resetLoop(): LoopInterface
	{
		if (!$this->loop)
		{
			throw new Exception('No loop runned');
		}
		$this->loop->stop();
		unset($this->loop);
		return $this->getLoop();
	}

	/**
	 * @return LoopInterface
	 */
	public function getLoop(): LoopInterface
	{
		if (!$this->loop)
		{
			$this->loop = Factory::create();
			$this->loop->run();
		}
		return $this->loop;
	}

	/**
	 * @param string $name
	 * @param int|float $time
	 * @param callable $callback
     *
	 * @return TimerInterface
	 * @throws Exception
	 */
	public function addTimer(string $name, $time, callable $callback): TimerInterface
	{
		if (array_key_exists($name, $this->timers))
		{
			throw new Exception('Timer name already exist');
		}

		return $this->timers[$name] = $this->getLoop()
		                                   ->addTimer($time, $callback)
			;
	}

	/**
	 * @param string $name
	 * @param int|float $interval
	 * @param callable $callback
     *
	 * @return TimerInterface
	 * @throws Exception
	 */
	public function addPeriodicTimer(string $name, $interval, callable $callback): TimerInterface
	{
		if (array_key_exists($name, $this->periodicTimers))
		{
			throw new Exception('Timer name already exist');
		}

		return $this->timers[$name] = $this->getLoop()
		                                   ->addPeriodicTimer($interval, $callback)
			;
	}

    /**
     * @param string $name
     *
     * @return EventLoopManager
     * @throws Exception
     */
	public function removeTimer(string $name)
	{
		$this->removeGeneralTimer($name, $this->timers);
		return $this;
	}

    /**
     * @param string $name
     * @param array  $collection
     *
     * @return EventLoopManager
     * @throws Exception
     */
	private function removeGeneralTimer(string $name, array $collection)
	{
		if (!$this->loop)
		{
			throw new Exception('No loop attached to manager, please consider attach timer before remove it');
		}
		if (!array_key_exists($name, $collection))
		{
			throw new Exception('Timer name not exist');
		}

		$this->loop->cancelTimer($collection[$name]);
		unset($collection[$name]);
		return $this;
	}

    /**
     * @param string $name
     *
     * @return EventLoopManager
     * @throws Exception
     */
	public function removePeriodicTimer(string $name): EventLoopManager
    {
		$this->removeGeneralTimer($name, $this->periodicTimers);
		return $this;
	}
}
