<?php

namespace PlumeSolution\Async\Managers\Package;

use Exception;
use PlumeSolution\Async\Models\Process;
use Ramsey\Uuid\Uuid;

class ProcessManager
{
	private array $process;

	/**
	 * @param string $order
	 * @param array $options
	 * @return string uuid of package
	 * @throws Exception
	 */
	public function createOrder(string $order, array $options): string
	{
		$process = new Process($order, $this, $options);

		return $this->registerNewProcess($process);
	}

	/**
	 * @param Process $process
	 * @return string
	 * @throws Exception
	 */
	private function registerNewProcess(Process $process): string
	{
		$uuid = $this->getNewUuid();

		$this->process[$uuid] = $process;

		$process->register($uuid);

		return $uuid;
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	private function getNewUuid(): string
	{
		// Define empty uuid for usage in do while loop.
		$uuid = null;

		// Generate uuid while key exist in registered process array (is process number for identify process in code).
		do
		{
			$uuid = Uuid::uuid1()
			            ->toString()
			;
		}
		while (array_key_exists($uuid, $this->process));

		return $uuid;
	}

	public function getTransportDriver(string $driver): TransportDriverInterface
	{

	}
}