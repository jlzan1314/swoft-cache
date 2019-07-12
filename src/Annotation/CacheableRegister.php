<?php
/**
 * Created by PhpStorm.
 * User: jlzan
 * Date: 2019/5/17
 * Time: 9:42
 */

namespace Jlzan1314\Cache\Annotation;

Use Jlzan1314\Cache\Annotation\Mapping\Cacheable;
use Jlzan1314\Cache\Cache;
use Jlzan1314\Cache\Group;
use Jlzan1314\Cache\Helper\StringHelper;

/**
 * Class GraphqlTagRegister
 *
 * @since 2.0
 */
class CacheableRegister
{
	private static $data = [];
	private static $listener = [];

	public static function register(string $class, string $method, Cacheable $annotation)
	{
		if (!isset(self::$data[$class])) {
			self::$data[$class] = [];
			if (!isset($data[$class][$method])) {
				self::$data[$class][$method] = [];
			}
		}
		self::$data[$class][$method] = $annotation;
	}

	public static function registerListener(string $listener, array $data)
	{
		self::$listener[$listener] = $data;
	}

	public static function getListener($listener): array
	{
		return self::$listener[$listener] ?? [];
	}

	public static function getAnnotation(string $class, string $method): ?Cacheable
	{
		return self::$data[$class][$method];
	}

	public static function getCacheableValue($className, $method, array $args): array
	{
		/** @var Cacheable $annotation */
		$annotation = self::getAnnotation($className, $method);
		$key = StringHelper::getFormatedKey($annotation->getPrefix(), $args, $annotation->getValue());
		/**
		 * @var Group $group
		 */
		$group = bean($annotation->getGroup()??Cache::DEFAULT_GROUP);
		$ttl = $annotation->getTtl() ?? $group->getTtl();
		return [$key, $ttl, $group, $annotation];
	}
}