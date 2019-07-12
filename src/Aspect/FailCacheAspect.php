<?php
declare(strict_types=1);

namespace Jlzan1314\Cache\Aspect;

use Jlzan1314\Cache\Annotation\Mapping\FailCache;
use Jlzan1314\Cache\Annotation\FailCacheRegister;
use Jlzan1314\Cache\Group;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Aop\Proxy;
use Swoft\Log\Helper\Log;

/**
 * @Aspect
 * @PointAnnotation({FailCache::class})
 */
class FailCacheAspect
{
	/**
	 * @Around()
	 * @param ProceedingJoinPoint $proceedingJoinPoint
	 * @return mixed
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
		[$key, $ttl, $group] = FailCacheRegister::getFailCacheValue($class, $method, $arguments);

		$driver = $group->getDriver();

		try {
			$result = $proceedingJoinPoint->proceed();
			$driver->set($key, $result, $ttl);
		} catch (\Throwable $throwable) {
			[$has, $result] = $driver->fetch($key);
			if (!$has) {
				throw $throwable;
			}
			Log::debug('Returns fail cache [%s]', $key);
		}

		return $result;
	}
}
