<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 20:09
 */

namespace Bridge\Skins;


abstract class SkinAbstract implements SkinInterface
{
	protected $name = null;

    public function getName()
    {
        return $this->name;
    }
}