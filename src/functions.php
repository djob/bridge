<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 28.02.15.
 * Time: 11:42
 */

if (! function_exists('bridge')) {
    function bridge()
    {
        return Bridge\Bridge::getInstance();
    }
}

if (! function_exists('bridge_assets')) {
    function bridge_assets()
    {
        return Bridge\Assets::getInstance();
    }
}