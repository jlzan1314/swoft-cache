<?php
/**
 * Created by PhpStorm.
 * User: jlzan
 * Date: 2019/5/17
 * Time: 9:42
 */

namespace Jlzan1314\Cache\Annotation;

Use Jlzan1314\Cache\Annotation\Mapping\CacheEvict;
use Jlzan1314\Cache\Cache;
use Jlzan1314\Cache\Helper\StringHelper;

/**
 * Class CacheEvictRegister
 *
 * @since 2.0
 */
class CacheEvictRegister
{
	private static $data = [];

	public static function register(string $class, string $method, CacheEvict $annotation)
	{
		if (!isset(self::$data[$class])) {
			self::$data[$class] = [];
			if (!isset($data[$class][$method])) {
				self::$data[$class][$method] = [];
			}
		}
		self::$data[$class][$method] = $annotation;
	}

	public static function getAnnotation(string $class, string $method): ?CacheEvict
	{
		return self::$data[$class][$method];
	}

	public static function getCacheEvictValue(string $className, string $method, array $arguments): array
	{
		/** @var CacheEvict $annotation */
		$annotation = self::getAnnotation($className, $method);

		$prefix = $annotation->getPrefix();
		$all = $annotation->isAll();
		$group = bean($annotation->getGroup()??Cache::DEFAULT_GROUP);

		if (! $all) {
			$key = StringHelper::getFormatedKey($prefix, $arguments, $annotation->getValue());
		} else {
			$key = $prefix . ':';
		}
		return [$key, $all, $group, $annotation];
	}
}