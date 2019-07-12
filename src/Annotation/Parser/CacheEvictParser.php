<?php declare(strict_types=1);


namespace Jlzan1314\Cache\Annotation\Parser;


use Jlzan1314\Cache\Annotation\CacheEvictRegister;
use Jlzan1314\Cache\Annotation\Mapping\CacheEvict;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;


/**
 * Class MiddlewareParser
 *
 * @since 2.0
 *
 * @AnnotationParser(CacheEvict::class)
 */
class CacheEvictParser extends Parser
{
	/**
	 * @param int $type
	 * @param CacheEvict $annotation
	 *
	 * @return array
	 */
	public function parse(int $type, $annotation): array
	{
		CacheEvictRegister::register($this->className,$this->methodName,$annotation);

		return [];
	}
}