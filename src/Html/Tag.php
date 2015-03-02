<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 12:31
 */
namespace Bridge\Html;

use ReflectionClass;

class Tag extends TagAbstract
{
	public function __construct($name, $content = null, $attributes = [])
	{

		$this->name($name);
		$this->content($content);
		$this->attributes($attributes);

		return $this;
	}

	public function __call($name, $arguments)
	{
		$instance = new ReflectionClass('Tag');
		array_unshift($arguments, $name);
		return $instance->newInstanceArgs($arguments);
	}
}