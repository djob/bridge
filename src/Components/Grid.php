<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 21:14
 */

namespace Bridge\Components;

use Bridge\Html\Table;

class Grid extends ComponentAbstract
{
    public function init($body = [], $header = [], $footer = [], $attributes = [])
    {
        $this->element(new Table($body, $header, $footer, $attributes));

        return $this;
    }
}