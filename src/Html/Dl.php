<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 09.03.15.
 * Time: 19:22
 */

namespace Bridge\Html;

class Dl extends Ul
{
    protected $name = self::TAG_LIST_DESC;

    protected function parseItems(array $data)
    {
        $items = [];

        foreach ($data as $param => $value) {
            $items[] = [
                'tag'        => self::TAG_LIST_DESC_KEY,
                'content'    => $param,
                'attributes' => $this->childAttributes
            ];
            $items[] = [
                'tag'        => self::TAG_LIST_DESC_VAL,
                'content'    => $value,
                'attributes' => $this->childAttributes
            ];
        }

        return $items;
    }
}