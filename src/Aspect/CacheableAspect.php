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


use Jlzan1314\Cache\Annotation\CacheableRegister;
use Jlzan1314\Cache\Annotation\Mapping\Cacheable;
use Jlzan1314\Cache\Driver\KeyCollectorInterface;
use Jlzan1314\Cache\Group;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Log\Helper\CLog;
use Swoft\Aop\Proxy;


/**
 * @Aspect()
 * @PointAnnotation({Cacheable::class})
 */
class CacheableAspect
{

	/**
	 * @Around()
	 *
	 * @param ProceedingJoinPoint $proceedingJoinPoint
	 *
	 * @return mixed
	 */
	public function around(ProceedingJoinPoint $proceedingJoinPoint)
	{
		// Before around
		$args = $proceedingJoinPoint->getArgs();

		$class = Proxy::getOriginalClassName(get_class($proceedingJoinPoint->getTarget()));
		$method = $proceedingJoinPoint->getMethod();

		/**
		 * @var Group $group
		 */
		[$key, $ttl, $group, $annotation] = CacheableRegister::getCacheableValue($class, $method, $args);

		$driver = $group->getDriver();
		[$has, $result] = $driver->fetch($key);
		if ($has) {
			return $result;
		}

		$result = $proceedingJoinPoint->proceed();

		$driver->set($key, $result, $ttl);
		if ($driver instanceof KeyCollectorInterface && $annotation instanceof Cacheable && $annotation->isCollect()) {
			$driver->addKey($annotation->getPrefix() . ':MEMBERS', $key);
		}

		return $result;
	}

}
