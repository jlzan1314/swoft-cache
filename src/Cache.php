<?php

declare(strict_types=1);
/**
 * .
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace Jlzan1314\Cache;

use Jlzan1314\Cache\Driver\DriverInterface;
use Psr\SimpleCache\CacheInterface;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Bean\Annotation\Mapping\Inject;

/**
 * Class Cache
 * @package Jlzan1314\Cache
 * @Bean("cache")
 */
class Cache implements CacheInterface
{
	const DEFAULT_GROUP = 'cache.group';
	/**
	 * 属性注入
	 * @var string
	 */
	private $prefix = "c:";

	/**
	 * @Inject(Cache::DEFAULT_GROUP)
	 * @var Group
	 */
	protected $group;

	/**
	 * @var DriverInterface
	 */
	protected $driver;

	public function init()
	{
		$this->driver = $this->group->getDriver();
	}

	public function __call($name, $arguments)
	{
		return $this->driver->{$name}(...$arguments);
	}

	public function get($key, $default = null)
	{
		return $this->__call(__FUNCTION__, func_get_args());
	}

	public function set($key, $value, $ttl = null)
	{
		return $this->__call(__FUNCTION__, func_get_args());
	}

	public function delete($key)
	{
		return $this->__call(__FUNCTION__, func_get_args());
	}

	public function clear()
	{
		return $this->__call(__FUNCTION__, func_get_args());
	}

	public function getMultiple($keys, $default = null)
	{
		return $this->__call(__FUNCTION__, func_get_args());
	}

	public function setMultiple($values, $ttl = null)
	{
		return $this->__call(__FUNCTION__, func_get_args());
	}

	public function deleteMultiple($keys)
	{
		return $this->__call(__FUNCTION__, func_get_args());
	}

	public function has($key)
	{
		return $this->__call(__FUNCTION__, func_get_args());
	}

	/**
	 * @return string
	 */
	public function getPrefix(): string
	{
		return $this->prefix;
	}
}
