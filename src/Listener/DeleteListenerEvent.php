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
use Jlzan1314\Cache\Exception\CacheException;

class DeleteListenerEvent extends DeleteEvent
{
    public function __construct(string $listener, array $arguments=[])
    {
        $config = CacheableRegister::getListener($listener);
        if (! $config) {
            throw new CacheException(sprintf('listener %s is not defined.', $listener));
        }

        $className = $config['className'];
        $method = $config['method'];

        parent::__construct($className, $method, $arguments);
    }
}
