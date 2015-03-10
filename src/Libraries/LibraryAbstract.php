<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 06.03.15.
 * Time: 18:58
 */

namespace Bridge\Libraries;

use Bridge\Assets;

class LibraryAbstract implements LibraryInterface
{
    protected $name    = null;
    protected $version = null;
    protected $js      = [];
    protected $css     = [];

    public function register()
    {

    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        return $this->name = $name;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        return $this->version = $version;
    }
}