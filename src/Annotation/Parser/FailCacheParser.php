<?php declare(strict_types=1);


namespace Jlzan1314\Cache\Annotation\Parser;


use Jlzan1314\Cache\Annotation\CacheableRegister;
use Jlzan1314\Cache\Annotation\FailCacheRegister;
use Jlzan1314\Cache\Annotation\Mapping\FailCache;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;


/**
 * Class MiddlewareParser
 *
 * @since 2.0
 *
 * @AnnotationParser(FailCache::class)
 */
class FailCacheParser extends Parser
{
	/**
	 * @param int $type
	 * @param FailCache $annotation
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
		FailCacheRegister::register($this->className,$this->methodName,$annotation);
		return [];
	}
}