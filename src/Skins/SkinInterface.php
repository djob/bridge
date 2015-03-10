<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 05.03.15.
 * Time: 06:25
 */

namespace Bridge\Skins;


interface SkinInterface
{
    /*
     * Called when skin is plugged in
     *
     * @return void
     */
    public function register();
}