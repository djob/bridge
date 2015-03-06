<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 04.03.15.
 * Time: 18:35
 */

namespace Bridge\Components;

use Bridge\Skins\SkinAbstract;
use ReflectionClass;

class ComponentFactory {
	public static function make($name, $arguments, SkinAbstract $skin = null)
	{
        $name = ucfirst(strtolower($name));

        if ($skin) {
            $class = 'Bridge\Skins\\' . $skin->getName() . '\\';
        } else {
            $class = 'Bridge\Components\\';
        }

        $class .= $name;

		if (class_exists($class)) {
			$instance = new ReflectionClass($class);
			return $instance->newInstanceArgs($arguments);
		}

		throw new ComponentException('Called invalid component:' . $class);
	}
}