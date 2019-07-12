<?php

declare(strict_types=1);

namespace Jlzan1314\Cache\Annotation\Mapping;

use Doctrine\Common\Annotations\Annotation\Attribute;
use Doctrine\Common\Annotations\Annotation\Attributes;
use Doctrine\Common\Annotations\Annotation\Required;
use Doctrine\Common\Annotations\Annotation\Target;


/**
 * Class Middleware
 *
 * @since 2.0
 *
 * @Annotation
 * @Target({"METHOD"})
 * @Attributes({
 *     @Attribute("prefix", type="string"),
 *     @Attribute("value", type="string"),
 *     @Attribute("ttl", type="int"),
 *     @Attribute("group", type="string"),
 *     @Attribute("listener", type="string"),
 * })
 */
class FailCache
{

	/**
	 * @var string
	 */
	private $prefix;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var int
	 */
	private $ttl;


	/**
	 * @var string
	 */
	private $listener;

	/**
	 * @var string
	 */
	private $group;

	/**
	 * @param array $values
	 */
	public function __construct(array $values)
	{
		if (isset($values['prefix'])) {
			$this->prefix = $values['prefix'];
		}

		if (isset($values['value'])) {
			$this->value = $values['value'];
		}

		if (isset($values['ttl'])) {
			$this->ttl = $values['ttl'];
		}

		if (isset($values['group'])) {
			$this->group = $values['group'];
		}

		if (isset($values['listener'])) {
			$this->group = $values['listener'];
		}
	}

	/**
	 * @return string
	 */
	public function getPrefix(): string
	{
		return $this->prefix;
	}

	/**
	 * @return string
	 */
	public function getValue(): string
	{
		return $this->value;
	}

	/**
	 * @return int
	 */
	public function getTtl(): int
	{
		return $this->ttl;
	}


	/**
	 * @return string
	 */
	public function getListener(): string
	{
		return $this->listener;
	}

	/**
	 * @return string
	 */
	public function getGroup(): string
	{
		return $this->group;
	}


}
