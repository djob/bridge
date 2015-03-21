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
        return $this->reflectionMethodCall($this->getReflectionObject(), $name, $arguments);
    }

    private function getReflectionObject()
    {
        if ($this->reflectionObject) {
            // Check if reflection object is defined as name of existing object
            if (is_string($this->reflectionObject)) {
                if (is_object($object = $this->{$this->reflectionObject})) {
                    return $object;
                }

                throw new \InvalidArgumentException(
                    sprintf("Unable to get reflection object! Object defined trough name %s, but property doesn't exists", $this->reflectionObject)
                );
            }

            return $this->reflectionObject;
        }

        throw new \InvalidArgumentException("Reflection object not set for usage in ReflectionMethodTrait");
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