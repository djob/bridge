<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 09.03.15.
 * Time: 19:22
 */

namespace Bridge\Html;

class Lists extends TagAbstract
{
    protected $name = self::TAG_LIST;

    public function __construct(array $list = [])
    {
        $this->items($list);
    }

    public function items(array $items = [])
    {
        if ($items) {
            $this->appendContent($items);
        }

        return $this->content;
    }

    protected function parseItems(array $items)
    {
        if (isset($items['tag'])) {
            return [$items];
        } else {
            foreach ($items as $index => &$child) {
                if (is_scalar($child)) {
                    $child = $this->normalize(self::TAG_LIST_ITEM, $child);
                } elseif (is_array($child)) {
                    foreach ($child as $subchild) {
                        $child = $this->parseItems($subchild);
                    }
                } elseif ($child instanceof TagAbstract) {
                    $child = $child->toArray();
                } else {
                    throw new \InvalidArgumentException(
                        "Cannot add this item to list. Scalar, array or TagAbstract accepted only!"
                    );
                }
            }
        }

        return $items;
    }

    public function add($item)
    {
        if ($items = $this->parseItems($item)) {
            $this->appendContent($items);
        }

        return $this->content;
    }

}