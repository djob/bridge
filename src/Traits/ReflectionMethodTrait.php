<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 09.03.15.
 * Time: 18:04
 */

namespace Bridge\Traits;

use ReflectionMethod;

trait ReflectionMethodTrait
{
    public function __call($name, $arguments)
    {
        return $this->reflectionMethodCall($this->reflectionObject, $name, $arguments);
    }

    protected function reflectionMethodCall($instance, $name, $arguments)
    {
        if (is_object($instance)) {
            $reflection = new ReflectionMethod($instance, $name);
            return $reflection->invokeArgs($instance, $arguments);
        }
    }
}