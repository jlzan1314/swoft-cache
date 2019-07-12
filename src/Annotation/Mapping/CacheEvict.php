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
 *     @Attribute("all", type="bool"),
 *     @Attribute("collect", type="bool"),
 *     @Attribute("group", type="string"),
 * })
 */
class CacheEvict
{
	private $prefix;

	private $value;

	private $group;

	private $all=false;
	private $collect=false;

	/**
	 * @param array $values
	 */
	public function __construct(array $values)
	{
		if (isset($values['value'])) {
			$this->value = $values['value'];
		}

		if (isset($values['prefix'])) {
			$this->prefix = $values['prefix'];
		}

		if (isset($values['all'])) {
			$this->all = $values['all'];
		}

		if (isset($values['group'])) {
			$this->group = $values['group'];
		}

		if (isset($values['collect'])) {
			$this->collect = $values['collect'];
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
	public function getGroup()
	{
		return $this->group;
	}

	/**
	 * @return bool
	 */
	public function isAll(): bool
	{
		return $this->all;
	}

	/**
	 * @return bool|mixed
	 */
	public function isCollect()
	{
		return $this->collect;
	}



}
