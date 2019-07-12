<?php declare(strict_types=1);


namespace Jlzan1314\Cache\Annotation\Parser;

use Jlzan1314\Cache\Annotation\CacheableRegister;
use Jlzan1314\Cache\Annotation\Mapping\Cacheable;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;

/**
 * Class MiddlewareParser
 *
 * @since 2.0
 *
 * @AnnotationParser(Cacheable::class)
 */
class CacheableParser extends Parser
{
	/**
	 * @param int $type
	 * @param Cacheable $annotation
	 *
	 * @return array
	 */
	public function parse(int $type, $annotation): array
	{
		if ($annotation->getListener()) {
			CacheableRegister::registerListener($annotation->getListener(),[
				'className'=>$this->className,
				"method"=>$this->methodName
			]);
		}
		CacheableRegister::register($this->className,$this->methodName,$annotation);
		return [];
	}
}