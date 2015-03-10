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
use Bridge\Traits\Instance;
use Bridge\Traits\Options;
use ReflectionMethod;

class Bridge
{
    use Instance;
    use Options;

    protected $skin      = null;
    protected $libraries = null;
    protected $options   = [
        'debug'       => false, // optional
     ];

    public function __construct(SkinInterface $skin = null, array $options = [])
    {
        // If skin is not defined, use Bootstrap as default
        if (!$this->skin && !$skin) {
            $skin = new \Bridge\Skins\Bootstrap();
        }

        if ($skin) {
            $this->setSkin($skin);
        }
        $this->libraries = new Libraries($this);
        $this->options['base_url'] = $this->baseUrl();
        self::setInstance($this);
        $this->initLibraries();
    }

    protected function initLibraries()
    {
        $this->libraries->registerLibraries();
    }

    public function baseUrl()
    {
        $protocol = (isset($_server['HTTPS']) && $_SERVER['HTTPS'] && ($_SERVER['HTTPS'] != "off")) ? "https" : "http";
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public static function debug()
    {
        return self::getInstance()->getOptions('debug');
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
}