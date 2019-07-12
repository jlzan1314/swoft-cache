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

use Psr\SimpleCache\CacheInterface;

interface DriverInterface extends CacheInterface
{
    /**
     * Return state of existence and data at the same time.
     * @param null|mixed $default
     */
    public function fetch(string $key, $default = null): array;

    /**
     * Clean up data of the same prefix.
     */
    public function clearPrefix(string $prefix): bool;
}
