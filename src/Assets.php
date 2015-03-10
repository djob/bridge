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
use Bridge\Traits\Instance;
use Bridge\Traits\Options;
use ReflectionMethod;

class Assets
{
    use Instance;
    use Options;

    protected $manager   = null;
    protected $libraries = null;
    protected $options   = [
        'path' => null // if empty, syspath will be used
    ];

    public function __construct(array $options = [])
    {
        $this->manager   = new Manager(new Adapter(), $this->getOption());

        self::setInstance($this);
    }

    public function call($name, $arguments)
    {
        $reflection = new ReflectionMethod($this->manager, $name);
        return $reflection->invokeArgs($this->manager, $arguments);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::getInstance()->call($name, $arguments);
    }

    public function __call($name, $arguments)
    {
        return $this->call($name, $arguments);
    }

}