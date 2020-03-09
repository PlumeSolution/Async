<?php


namespace PlumeSolution\Async\Drivers\TransportDrivers;


use Exception;
use PlumeSolution\Async\Models\Process;
use React\EventLoop\LoopInterface;

class ProcessPipeTransportDriver implements TransportDriverInterface
{
	/**
	 * @var LoopInterface
	 */
	private LoopInterface $loop;
	/**
	 * @var \React\ChildProcess\Process
	 */
	private \React\ChildProcess\Process $process;

	public function __construct(array $options, LoopInterface $loop)
	{
		$this->loop = $loop;
	}

	public function send(Process $process)
	{
		$this->process = New \React\ChildProcess\Process($process->getOrder());
		$this->process->start($this->loop);
		$this->createEvent($this->process, $process);
	}

	private function createEvent(\React\ChildProcess\Process $cliprocess, Process $process)
	{
		$data = $process->getData();
		$cliprocess->stdout->on('data', function ($chunk) use ($data)
		{
			$data[] = $chunk;
		});

		$cliprocess->stdout->on('end', function () use ($process)
		{
			$process->end();
		});

		$cliprocess->stdout->on('error', function (Exception $e)
		{
			throw $e;
		});
	}
}