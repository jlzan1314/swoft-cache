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

namespace Jlzan1314\Cache\Driver;

abstract class Driver implements DriverInterface
{
    protected function getCacheKey(string $key)
    {
        return bean('cache')->getPrefix() . $key;
    }
}
