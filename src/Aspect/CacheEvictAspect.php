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

namespace Jlzan1314\Cache\Aspect;

use Jlzan1314\Cache\Annotation\CacheEvictRegister;
use Jlzan1314\Cache\Annotation\Mapping\CacheEvict;
use Jlzan1314\Cache\Driver\KeyCollectorInterface;
use Jlzan1314\Cache\Group;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Aop\Proxy;

/**
 * @Aspect()
 * @PointAnnotation({CacheEvict::class})
 */
class CacheEvictAspect
{
	/**
	 * @Around()
	 * @param ProceedingJoinPoint $proceedingJoinPoint
	 * @return mixed
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 * @throws \Throwable
	 */
	public function around(ProceedingJoinPoint $proceedingJoinPoint)
	{
		$class = Proxy::getOriginalClassName(get_class($proceedingJoinPoint->getTarget()));
		$method = $proceedingJoinPoint->getMethod();
		$arguments = $proceedingJoinPoint->getArgs();

		/**
		 * @var Group $group
		 */
		[$key, $all, $group, $annotation] = CacheEvictRegister::getCacheEvictValue($class, $method, $arguments);

		$driver = $group->getDriver();

		if ($all) {
			if ($driver instanceof KeyCollectorInterface && $annotation instanceof CacheEvict && $annotation->isCollect()) {
				$collector = $annotation->getPrefix() . ':MEMBERS';
				$keys = $driver->keys($collector);
				if ($keys) {
					$driver->deleteMultiple($keys);
					$driver->delete($collector);
				}
			} else {
				$driver->clearPrefix($key);
			}
		} else {
			$driver->delete($key);
		}

		return $proceedingJoinPoint->proceed();
	}
}
