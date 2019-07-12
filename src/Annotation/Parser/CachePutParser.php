<?php declare(strict_types=1);


namespace Jlzan1314\Cache\Annotation\Parser;


use Jlzan1314\Cache\Annotation\CachePutRegister;
use Jlzan1314\Cache\Annotation\Mapping\CachePut;
use Swoft\Annotation\Annotation\Mapping\AnnotationParser;
use Swoft\Annotation\Annotation\Parser\Parser;

/**
 * Class MiddlewareParser
 *
 * @since 2.0
 *
 * @AnnotationParser(CachePut::class)
 */
class CachePutParser extends Parser
{
	/**
	 * @param int $type
	 * @param CachePut $annotationObject
	 *
	 * @return array
	 */
	public function parse(int $type, $annotationObject): array
	{
		CachePutRegister::register($this->className, $this->methodName, $annotationObject);
		return [];
	}
}