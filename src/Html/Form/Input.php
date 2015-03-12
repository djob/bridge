<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.03.15.
 * Time: 20:40
 */

namespace Bridge\Html\Form;

use Bridge\Html\TagAbstract;

class Input extends TagAbstract
{
    protected $name       = self::TAG_TABLE;
    protected $attributes = [
        'type' => null,
        'name' => null
    ];

    public function __construct($type, $name, array $attributes = [])
    {
        $this->attributes['type'] = $type;
        $this->attributes['name'] = $name;
        $this->attributes(array_merge($attributes, $this->attributes));

        return $this;
    }
}