<?php

namespace PlumeSolution\Async\Managers\Transport;

use React\Cache\ArrayCache;

class DriverManager
{
	public function __construct()
	{
		new ArrayCache(null);
	}
}