<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 20:09
 */

namespace Bridge\Skins;

use Bridge\Assets;
use Bridge\Traits\AssetsTrait;

abstract class SkinAbstract implements SkinInterface
{
    use AssetsTrait;

    protected $version      = null;
    protected $name         = null;
    protected $css          = [];
    protected $js           = [];
    //@TODO - consider to include bower.json/packages.json in skins folder and read needed informations
    // e.g dependencies, name, description, version, etc
    protected $dependencies = [];

    public function __construct()
    {

    }

    public function register()
    {
        $this->addAssets();
    }

    public function getName()
    {
        return $this->name;
    }
}