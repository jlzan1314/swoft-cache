<?php
/**
 * Created by PhpStorm.
 * User: jlzan
 * Date: 2019/5/17
 * Time: 9:42
 */

namespace Jlzan1314\Cache\Annotation;

Use Jlzan1314\Cache\Annotation\Mapping\CachePut;
use Jlzan1314\Cache\Cache;
use Jlzan1314\Cache\Group;
use Jlzan1314\Cache\Helper\StringHelper;

/**
 * Class CachePutRegister
 *
 * @since 2.0
 */
class CachePutRegister
{
	private static $data = [];

	public static function register(string $class, string $method, CachePut $annotation)
	{
		if (!isset(self::$data[$class])) {
			self::$data[$class] = [];
			if (!isset($data[$class][$method])) {
				self::$data[$class][$method] = [];
			}
		}
		self::$data[$class][$method] = $annotation;
	}

	public static function getAnnotation(string $class, string $method): ?CachePut
	{
		return self::$data[$class][$method];
	}

	public static function getCachePutValue(string $className, string $method, array $arguments): array
	{
		$annotation = self::getAnnotation($className, $method);
		$key = StringHelper::getFormatedKey($annotation->getPrefix(), $arguments, $annotation->getValue());
		/**
		 * @var Group $group
		 */
		$group = bean($annotation->getGroup()??Cache::DEFAULT_GROUP);
		$ttl = $annotation->getTtl() ?? $group->getTtl();
		return [$key, $ttl, $group, $annotation];
	}
}