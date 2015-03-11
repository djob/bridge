<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 09.03.15.
 * Time: 18:04
 */

namespace Bridge\Traits;

trait SingeltonTrait
{
    public static $instance = null;

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setInstance($instance)
    {
        return self::$instance = $instance;
    }
}