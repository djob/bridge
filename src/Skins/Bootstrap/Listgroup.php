<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 12.03.15.
 * Time: 20:17
 */

namespace Bridge\Skins\Bootstrap;

use Bridge\Components\ComponentAbstract;
use Bridge\Html\Ul;

class Listgroup extends ComponentAbstract
{

    public function init(array $items)
    {
        $this->element(new Ul($items));
    }
}