<?php

declare(strict_types=1);

namespace Jlzan1314\Cache\Driver;

use Jlzan1314\Cache\Exception\InvalidArgumentException;
use Swoft\Redis\Pool;

/**
 * Class RedisDriver
 * @package Jlzan1314\Cache\Driver
 */
class RedisDriver extends Driver implements KeyCollectorInterface
{
    /**
     * @var Pool
     */
    protected $redis;

	public function get($key, $default = null)
    {
        $res = $this->redis->get($this->getCacheKey($key));
        if ($res === false) {
            return $default;
        }
        return $res;
    }

    public function fetch(string $key, $default = null): array
    {
        $res = $this->redis->get($this->getCacheKey($key));
        if ($res === false) {
            return [false, $default];
        }
        return [true, $res];
    }

    public function set($key, $value, $ttl = null)
    {
        if ($ttl > 0) {
            return $this->redis->set($this->getCacheKey($key), $value, $ttl);
        }

        return $this->redis->set($this->getCacheKey($key), $value);
    }

    public function delete($key)
    {
        return (bool) $this->redis->del($this->getCacheKey($key));
    }

    public function clear()
    {
        return $this->clearPrefix('');
    }

    public function getMultiple($keys, $default = null)
    {
        $cacheKeys = array_map(function ($key) {
            return $this->getCacheKey($key);
        }, $keys);

        $values = $this->redis->mget($cacheKeys);
        $result = [];
        foreach ($keys as $i => $key) {
            $result[$key] = $values[$i] === false ? $default : $values[$i];
        }

        return $result;
    }

    public function setMultiple($values, $ttl = null)
    {
        if (! is_array($values)) {
            throw new InvalidArgumentException('The values is invalid!');
        }

        $cacheKeys = [];
        foreach ($values as $key => $value) {
            $cacheKeys[$this->getCacheKey($key)] = $value;
        }

        $ttl = (int) $ttl;
        if ($ttl > 0) {
            foreach ($cacheKeys as $key => $value) {
                $this->redis->set($key, $value, $ttl);
            }
            return true;
        }

        return $this->redis->mset($cacheKeys);
    }

    public function deleteMultiple($keys)
    {
        $cacheKeys = array_map(function ($key) {
            return $this->getCacheKey($key);
        }, $keys);

        return $this->redis->del(...$cacheKeys);
    }

    public function has($key)
    {
        return (bool) $this->redis->exists($this->getCacheKey($key));
    }

    public function clearPrefix(string $prefix): bool
    {
        $iterator = 0;
        $key = $prefix . '*';
        while ($keys = $this->redis->scan($iterator, $this->getCacheKey($key), 10000)) {
            $this->redis->del(...$keys);
        }

        return true;
    }

    public function addKey(string $collector, string $key): bool
    {
        return (bool) $this->redis->sAdd($this->getCacheKey($collector), $key);
    }

    public function keys(string $collector): array
    {
        return $this->redis->sMembers($this->getCacheKey($collector)) ?? [];
    }

    public function delKey(string $collector, ...$key): bool
    {
        return (bool) $this->redis->sRem($this->getCacheKey($collector), ...$key);
    }
}
