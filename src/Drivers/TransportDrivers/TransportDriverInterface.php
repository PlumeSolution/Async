<?php


namespace PlumeSolution\Async\Drivers\TransportDrivers;


use PlumeSolution\Async\Models\Process;
use React\EventLoop\LoopInterface;

interface TransportDriverInterface
{
	public function __construct(array $options, LoopInterface $loop);

	public function send(Process $process);
}