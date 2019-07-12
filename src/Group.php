<?php
/**
 * Created by PhpStorm.
 * User: jlzan
 * Date: 2019/7/11
 * Time: 14:53
 */

namespace Jlzan1314\Cache;

use Jlzan1314\Cache\Driver\DriverInterface;

class Group
{
	private $ttl=3600;
	private $driver;

	/**
	 * @return int
	 */
	public function getTtl(): int
	{
		return $this->ttl;
	}

	/**
	 * @return string
	 */
	public function getDriver():DriverInterface
	{
		return $this->driver;
	}
}