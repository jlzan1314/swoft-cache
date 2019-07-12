<?php

declare(strict_types=1);

namespace Jlzan1314\Cache\Helper;

use Swoft\Stdlib\Helper\StringHelper as base;
use Swoft\Stdlib\Helper\ArrayHelper;
use Swoft\Log\Helper\Log;

class StringHelper extends base
{
	/**
	 * Format cache key with prefix and arguments.
	 */
	public static function format(string $prefix, array $arguments, ?string $value = null): string
	{
		if ($value !== null) {
			if ($matches = self::parse($value)) {
				foreach ($matches as $search) {
					$k = str_replace('#{', '', $search);
					$k = str_replace('}', '', $k);
					$value = self::replaceFirst($search, (string)ArrayHelper::get($arguments, $k), $value);
				}
			}
		} else {
			$value=implode(':', $arguments);
		}

		if ($value!=="") {
			$key = $prefix . ':' . $value;
		}else{
			$key = $prefix;
		}

		return $key;
	}

	public static function getFormatedKey(string $prefix, array $arguments, ?string $value = null): string
	{
		$key = StringHelper::format($prefix, $arguments, $value);

		if (strlen($key) > 64) {
			Log::warning('The cache key length is too long. The key is %s', $key);
		}

		return $key;
	}

	/**
	 * Parse expression of value.
	 */
	public static function parse(string $value): array
	{
		preg_match_all('/\#\{[\w\.]+\}/', $value, $matches);

		return $matches[0] ?? [];
	}
}
