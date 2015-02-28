<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 12:31
 */
namespace Bridge\Html;

use ReflectionClass;

class Element extends ElementAbstract
{
	public function __construct($tagName, $attributes = [], $content = null)
	{

	}

	public function __call($name, $arguments)
	{
		$instance = new ReflectionClass('\Djob\Bridge\Html\Element');
		array_unshift($arguments, $name);
		return $instance->newInstanceArgs($arguments);
	}
}