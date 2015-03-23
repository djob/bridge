<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:12
 */
namespace Bridge;

use Bridge\Skins\SkinInterface;
use Bridge\Components\ComponentFactory;
use Bridge\Traits\SingeltonTrait;
use ReflectionMethod;

class Bridge
{
    use SingeltonTrait;

    protected $skin = null;
    protected $libraries = null;

    public function __construct(SkinInterface $skin = null)
    {
        // If skin is not defined, use Bootstrap as default
        if (!$this->skin && !$skin) {
            $skin = new \Bridge\Skins\Bootstrap();
        }

        if ($skin) {
            $this->setSkin($skin);
        }
        $this->libraries = new Libraries($this);

        self::setInstance($this);
        $this->initLibraries();
    }

    protected function initLibraries()
    {
        $this->libraries->registerLibraries();
    }

    public static function path($path = null)
    {
        $basePath = dirname(__FILE__);

        if ($path) {
            $basePath .= '\\' . ltrim($path, '\/');
        }

        return $basePath;
    }

    public static function __callStatic($name, $arguments)
    {
        $instance = self::getInstance();

        //@TODO remove this part (method_exists), if existing method is called error will be dropped
        if (method_exists($instance, $name)) {
            $reflection = new ReflectionMethod($instance, $name);

            return $reflection->invokeArgs($instance, $arguments);
        } else {
            return ComponentFactory::make($name, $arguments, $instance->getSkin());
        }
    }

    public function component($name)
    {
        $arguments = func_get_args();
        array_shift($arguments);

        return ComponentFactory::make($name, $arguments, $this->getSkin());
    }

    public function getSkin()
    {
        return $this->skin;
    }

    public function setSkin(SkinInterface $skin)
    {
        $skin->register();

        return $this->skin = $skin;
    }
}