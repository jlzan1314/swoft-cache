<?php declare(strict_types=1);

namespace Jlzan1314\Cache;

use Jlzan1314\Cache\Driver\RedisDriver;
use Swoft\SwoftComponent;
use Swoft\Redis\Pool;

class AutoLoader extends SwoftComponent
{
	/**
	 * @return array
	 */
	public function getPrefixDirs(): array
	{
		return [
			__NAMESPACE__ => __DIR__,
		];
	}

	/**
	 * @return array
	 */
	public function metadata(): array
	{
		return [];
	}

	/**
	 * @return array
	 */
	public function beans(): array
	{
		return [
			'cache.driver'=>[
				'class'=>RedisDriver::class,
				'redis'=>bean(Pool::DEFAULT_POOL)
			],
			'cache.group'=>[
				'class'=>Group::class,
				'driver'=>bean("cache.driver")
			]
		];
	}

}
