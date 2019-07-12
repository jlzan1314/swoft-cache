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

namespace Jlzan1314\Cache\Listener;

use Jlzan1314\Cache\Annotation\CacheableRegister;
use Jlzan1314\Cache\Annotation\Mapping\Cacheable;
use Jlzan1314\Cache\CacheEvent;
use Jlzan1314\Cache\Driver\KeyCollectorInterface;
use Jlzan1314\Cache\Group;
use Swoft\Event\Annotation\Mapping\Listener;
use Swoft\Event\EventHandlerInterface;
use Swoft\Event\EventInterface;

/**
 * @Listener(CacheEvent::DELETE_EVENT)
 */
class DeleteListener implements EventHandlerInterface
{
	public function handle(EventInterface $event): void
	{
		if ($event instanceof DeleteListenerEvent) {
			$className = $event->getClassName();
			$method = $event->getMethod();
			$arguments = $event->getParams();
			/**
			 * @var Group $group
			 */
			[$key, , $group, $annotation] = CacheableRegister::getCacheableValue($className, $method, $arguments);

			$driver = $group->getDriver();
			$driver->delete($key);
			if ($driver instanceof KeyCollectorInterface && $annotation instanceof Cacheable) {
				$driver->delKey($annotation->getPrefix() . ':MEMBERS', $key);
			}
		}
	}

}
