<?php

namespace PlumeSolution\Async\Models;

use Exception;
use PlumeSolution\Async\Drivers\TransportDrivers\ProcessPipeTransportDriver;
use PlumeSolution\Async\Managers\Package\ProcessManager;
use React\Promise\Promise;

class Process
{
	private array $defaultConfigs =
		[
			'transport' => ProcessPipeTransportDriver::class,
			'timeout'   => 10.0,
		];

	/**
	 * @var string
	 */
	private string $order;

	/**
	 * @var string
	 */
	private string $transport;

	/**
	 * @var float
	 */
	private float $timeout;

	/**
	 * @var array
	 */
	private array $data;

	/**
	 * @var string
	 */
	private string $uuid;

	/**
	 * @var ProcessManager
	 */
	private ProcessManager $packageManager;

	/**
	 * @var Promise|null
	 */
	private ?Promise $promise;

	/**
	 * @var bool
	 */
	private bool $ended;


	/**
	 * Package constructor.
	 *
	 * @param string $order
	 * @param ProcessManager $packageManager
	 * @param array $options
	 */
	public function __construct(string $order, ProcessManager $packageManager, array $options = [])
	{
		$this->order = $order;
		$this->packageManager = $packageManager;
		$this->configure($options, true);
		$this->promise = new Promise($this->createResolver($packageManager), $this->createCanceller());
	}

	private function configure(array $params, bool $withDefault = false)
	{

		if ($withDefault)
		{
			$this->configureDefault();
		}

		foreach ($params as $key => $param)
		{
			if ($this->$key)
			{
				$this->$key = $param;
			}
		}
	}

	/**
	 * Set default parameter to Package
	 */
	private function configureDefault(): void
	{
		foreach ($this->defaultConfigs as $key => $param)
		{
			if ($this->$key)
			{
				$this->$key = $param;
			}
		}
	}

	/**
	 * @param $packageManager
	 * @return callable
	 * @Todo abord method to configure promise
	 */
	private function createResolver($packageManager): callable
	{
		return function (callable $resolve, callable $reject) use ($packageManager)
		{
			//Todo abord method used to execute promise
			//$resolve($data); // probably good method for resolve the result
		};
	}

	/**
	 * @return callable
	 */
	private function createCanceller(): callable
	{
		return function ()
		{ //Todo abord method to cancel action
			// Cancel/abort any running operations like network connections, streams etc.

			// Reject promise by throwing an exception
			throw new Exception('Promise cancelled');
		};
	}

	/**
	 * Set the uuid Registered in repository
	 *
	 * @param string $uuid
	 */
	public function register(string $uuid)
	{
		$this->uuid = $uuid;
	}

	/**
	 * @return string
	 */
	public function getOrder(): string
	{
		return $this->order;
	}

	/**
	 * @param string $order
	 */
	public function setOrder(string $order)
	{
		$this->order = $order;
	}

	/**
	 * @return array
	 */
	public function getData(): array
	{
		return $this->data;
	}

	/**
	 * @param array $data
	 */
	public function setData(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return string
	 */
	public function getTransport(): string
	{
		return $this->transport;
	}

	/**
	 * @return string
	 */
	public function getUuid(): string
	{
		return $this->uuid;
	}

	/**
	 * @param string $uuid
	 */
	public function setUuid(string $uuid): void
	{
		$this->uuid = $uuid;
	}

	/**
	 *
	 */
	public function end()
	{
		$this->ended = true;
	}

	/**
	 * @return bool
	 */
	public function isEnded(): bool
	{
		return $this->ended;
	}
}