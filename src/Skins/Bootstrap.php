<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 05.03.15.
 * Time: 06:27
 */

namespace Bridge\Skins;

class Bootstrap extends SkinAbstract
{
    const CLASS_ACTIVE  = 'active';
    const CLASS_SUCCESS = 'success';
    const CLASS_INFO    = 'info';
    const CLASS_WARNING = 'warning';
    const CLASS_DANGER  = 'danger';

    protected $version         = '3.3.2';
    protected $name            = 'bootstrap';
    protected $css             = ['//maxcdn.bootstrapcdn.com/bootstrap/{@version}/css/bootstrap.min.css'];
    protected $js              = ['//maxcdn.bootstrapcdn.com/bootstrap/{@version}/js/bootstrap.min.js'];
    protected $dependencies    = ['jquery' => '1.9.1'];

}