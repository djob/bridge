<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 10.03.15.
 * Time: 19:22
 */

namespace Bridge;

class Config
{
    private static $config = [
        'debug' => false,
        'assets_path' => null
    ];

    public static function debug()
    {
        return self::get('debug') == true;
    }

    public static function baseUrl()
    {
        $protocol = (isset($_server['HTTPS']) && $_SERVER['HTTPS'] && ($_SERVER['HTTPS'] != "off")) ? "https" : "http";
        return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    private static function setConfig($key, $value)
    {
        self::$config[$key] = $value;
    }

    public static function all()
    {
        return self::$config;
    }

    public static function get($param, $default = false)
    {
        if (isset(self::$config[$param])) {
            return self::$config[$param];
        }

        return $default;
    }

    public static function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $param => $val) {
                self::setConfig($param, $val);
            }
        } else {
            self::setConfig($key, $value);
        }
    }

}