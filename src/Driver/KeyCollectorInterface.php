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

interface KeyCollectorInterface
{
    public function addKey(string $collector, string $key): bool;

    public function keys(string $collector): array;

    public function delKey(string $collector, ...$key): bool;
}
