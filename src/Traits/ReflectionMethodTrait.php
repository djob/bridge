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

    protected function setReflectionObject($object)
    {
        $this->reflectionObject = $object;
    }

    protected function reflectionMethodCall($instance, $name, $arguments)
    {
        if (is_object($instance)) {
            if (method_exists($instance, $name)) {
                $reflection = new ReflectionMethod($instance, $name);
                return $reflection->invokeArgs($instance, $arguments);
            } else {
                throw new \BadMethodCallException(
                    sprintf('Unable to call reflection method "%s". Method not exists!', __CLASS__ . '::' . $name)
                );
            }
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Unable to call reflection method "%s". Reflection object not valid object',
                __CLASS__ . '::' . $name
            )
        );
    }
}