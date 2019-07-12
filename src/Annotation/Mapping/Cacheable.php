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
 *     @Attribute("ttl", type="int"),
 *     @Attribute("listener", type="string"),
 *     @Attribute("value", type="string"),
 *     @Attribute("group", type="string"),
 *     @Attribute("collect", type="bool"),
 * })
 */
class Cacheable
{
	/**
	 * @var string 那些分类下不能显示
	 *
	 * @Required()
	 */
	private $prefix;

	/**
	 * @var string 格式后成redisKey
	 *
	 */
	private $value;

	private $ttl;

	private $listener;

	/**
	 * @var string 使用那个group
	 */
	private $group;

	/**
	 * @var bool
	 */
	private $collect = false;

	/**
	 * Middleware constructor.
	 *
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

		if (isset($values['listener'])) {
			$this->listener = $values['listener'];
		}

		if (isset($values['group'])) {
			$this->group = $values['group'];
		}

		if (isset($values['collect'])) {
			$this->collect = $values['collect'];
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
	public function getValue(): ?string
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
	public function getListener()
	{
		return $this->listener;
	}


	/**
	 * @return string
	 */
	public function getGroup(): ?string
	{
		return $this->group;
	}

	/**
	 * @return bool
	 */
	public function isCollect(): bool
	{
		return $this->collect;
	}
}
