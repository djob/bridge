<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 21:14
 */

namespace Bridge\Components;

use Bridge\Html\Ul;
use Bridge\Html\Dl;
use Bridge\Html\Ol;

class Listing extends ComponentAbstract
{
    const UL = 'Ul';
    const DL = 'Dl';
    const OL = 'Ol';

    protected $items = [];

    public function init(array $items, array $attributes = [], $type = self::UL)
    {
        $this->element = $this->make($type, $items, $attributes);

        return $this;
    }

    private function make($type, array $items, array $attributes = [])
    {
        if (class_exists($type)) {
            $this->element = new $type($items, $attributes);
            return $this;
        }

        throw new \InvalidArgumentException(
            sprintf("Unable to create list element. '%s' is invalid list type", $type)
        );
    }

    public function ordered(array $items, array $attributes = [])
    {
        $this->element = $this->make(self::OL, $items, $attributes);
        return $this;
    }

    public function description(array $items, array $attributes = [])
    {
        $this->element = $this->make(self::DL, $items, $attributes);
        return $this;
    }

    public function normal(array $items, array $attributes = [])
    {
        $this->element = $this->make(self::UL, $items, $attributes);
        return $this;
    }

}