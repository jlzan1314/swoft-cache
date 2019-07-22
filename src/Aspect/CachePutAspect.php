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

use Jlzan1314\Cache\Annotation\CachePutRegister;
use Jlzan1314\Cache\Annotation\Mapping\CachePut;
use Jlzan1314\Cache\Group;
use Swoft\Aop\Annotation\Mapping\Around;
use Swoft\Aop\Annotation\Mapping\Aspect;
use Swoft\Aop\Annotation\Mapping\PointAnnotation;
use Swoft\Aop\Point\ProceedingJoinPoint;
use Swoft\Aop\Proxy;

/**
 * @Aspect
 * @PointAnnotation({CachePut::class})
 */
class CachePutAspect
{

	/**
	 * @Around()
	 * @param ProceedingJoinPoint $proceedingJoinPoint
	 * @return mixed
	 */
    public function around(ProceedingJoinPoint $proceedingJoinPoint)
    {
	    $class = $proceedingJoinPoint->getClassName();
        $method = $proceedingJoinPoint->getMethod();
        $arguments = $proceedingJoinPoint->getArgsMap();
	    /**
	     * @var Group $group
	     */
        [$key, $ttl, $group] = CachePutRegister::getCachePutValue($class, $method, $arguments);
        $driver = $group->getDriver();
        $result = $proceedingJoinPoint->proceed();
        $driver->set($key, $result, $ttl);
        return $result;
    }
}
