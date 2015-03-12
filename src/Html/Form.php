<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 12.03.15.
 * Time: 06:59
 */

namespace Bridge\Html;

class Form extends TagAbstract
{
    public function __construct()
    {
        $args = func_get_args();

        if (count($args) == 1) {
            $this->attributes($args[0]);
        } elseif (count($args) == 2) {
            $this->elements($args[0]);
            $this->attributes($args[1]);
        } else {
            throw new \InvalidArgumentException('Invalid number of arguments provided!');
        }

        return $this;
    }

    public function elements(array $elements = [])
    {
        $this->content($elements);
        return $this;
    }

    public function add($element)
    {
        $this->appendContent($element);
        return $this;
    }
}