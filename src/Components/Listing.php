<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 21:14
 */

namespace Bridge\Components;

class Listing extends ComponentAbstract
{
    const UL = 'Ul';
    const DL = 'Dl';
    const OL = 'Ol';

    protected $items           = [];
    protected $childAttributes = [];

    public function init(array $items, array $attributes = [], $type = self::UL)
    {
        $this->make($type, [], $attributes, $this->childAttributes);
        $this->element()->items($items);

        return $this;
    }

    protected function make($type, array $items, array $attributes = [], array $childAttributes = [])
    {
        $class = 'Bridge\Html\\' . $type;

        if (class_exists($class)) {
            $this->element(new $class($items, $attributes, $childAttributes));

            return $this;
        }

        throw new \InvalidArgumentException(
            sprintf("Unable to create list element. '%s' is invalid list type", $type)
        );
    }

    public function ordered(array $items = [], array $attributes = [])
    {
        $this->switchType(self::OL, $items, $attributes);
    }

    protected function switchType($type, array $items, array $attributes)
    {
        if ($items) {
            $this->element = $this->make($type, $items, $attributes);
        } else {
            $this->element->name($type);
        }

        return $this;
    }

    public function description(array $items, array $attributes = [])
    {
        $this->switchType(self::DL, $items, $attributes);
    }

    public function normal(array $items, array $attributes = [])
    {
        $this->switchType(self::UL, $items, $attributes);
    }

}