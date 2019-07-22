## 感谢

本项目是基于hyperf/cache项目开发的,觉得不错,加上项目使用swoft2,就移植过来了

## 安装
```
//install by composer
composer require jlzan1314/swoft-cache
```
## 用法
#### 新group配置
```php
//bean.php

'cache.group2'=>[
    'class'=>\Jlzan1314\Cache\Group::class,
    'driver'=>bean("cache.driver"),
    'ttl'=>500,//默认的ttl
],

```

## psr/simpleCache的使用方式
```php
$cache=bean('cache');
```

## 和hyperf不同的地方
1.0 注解中 value="" 只支持#{0}替代,不支持具名替代#{id} 

1.1 已经完全和hyperf一样了,需要swoft2.0.4

## 示列
```php
<?php declare(strict_types=1);


namespace App\Http\Controller;

use Jlzan1314\Cache\Annotation\Mapping\Cacheable;
use Jlzan1314\Cache\Annotation\Mapping\CacheEvict;
use Jlzan1314\Cache\Annotation\Mapping\CachePut;
use Jlzan1314\Cache\Listener\DeleteListenerEvent;
use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;

/**
 * Class LogController
 *
 * @since 2.0
 *
 * @Controller("test")
 */
class TestController
{

	/**
	 * @RequestMapping("cache")
	 * 缓存使用
	 * @throws ReflectionException
	 * @throws ContainerException
	 */
	public function cache()
	{
		$cache=$this->cacheable(1);
		$cache2=$this->cachePut(1,2);
		$cacheGroup=$this->cacheGroup();
		return compact('cache','cache2','cacheGroup');
	}


	/**
     * 清除缓存
	 * @RequestMapping("delCache")
	 * 
	 * @throws ReflectionException
	 * @throws ContainerException
	 */
	public function delCache(){
		\Swoft::trigger(new DeleteListenerEvent('deleteDdd',[1]));
		\Swoft::trigger(new DeleteListenerEvent('deleteGroup'));
		$this->cacheEvict(1,2);
		return "delete success";
	}

	/**
	 * @Cacheable(prefix="ddd",ttl=3600,listener="deleteDdd")
	 */
	public function cacheable($id){
		return date("Y-m-d H:i:s");
	}

	/**
	 * @CachePut(prefix="put",ttl=300,value="#{id}:#{arg2}")
	 * @param $id
	 */
	public function cachePut($id,$arg2){
		return date("Y-m-d H:i:s");
	}

	/**
	 * 清除缓存信息
	 * @CacheEvict(prefix="put", value="#{id}:#{arg2}")
	 */
	public function cacheEvict($id,$arg2){
		return true;
	}

	/**
	 * 清除缓存信息
	 * @Cacheable(prefix="group",group="cache.group2",listener="deleteGroup")
	 */
	public function cacheGroup(){
		return date("Y-m-d H:i:s");
	}
}
```
## 具体的使用说明参考 hyperf
1. https://doc.hyperf.io/#/zh/cache?id=cacheable

