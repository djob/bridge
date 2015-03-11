<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:12
 */
namespace Bridge;

use Bridge\Assets\Manager;
use Bridge\Assets\Adapter;
use Bridge\Traits\SingeltonTrait;
use Bridge\Traits\ReflectionMethodTrait;

class Assets
{
    use SingeltonTrait;
    use ReflectionMethodTrait;

    protected $reflectionObject = null;
    protected $manager   = null;
    protected $libraries = null;

    public function __construct()
    {
        $this->manager   = new Manager(new Adapter());
        $this->reflectionObject = $this->manager;
        self::setInstance($this);
        return $this;
    }

    public static function __callStatic($name, $arguments)
    {
        $instance = self::getInstance();
        return $instance->reflectionMethodCall($instance->manager, $name, $arguments);
    }
}