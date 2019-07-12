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
 * })
 */
class CachePut
{
    private $prefix;

	private $value;

	private $ttl;

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
			$this->ttl= $values['ttl'];
		}

		if (isset($values['group'])) {
			$this->group = $values['group'];
		}
	}

	/**
	 * @return mixed
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @return mixed
	 */
	public function getTtl()
	{
		return $this->ttl;
	}

	/**
	 * @return mixed
	 */
	public function getGroup()
	{
		return $this->group;
	}

}
