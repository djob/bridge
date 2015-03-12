<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 09.03.15.
 * Time: 19:22
 */

namespace Bridge\Html;

class Ul extends TagAbstract
{
    protected $name            = self::TAG_LIST;
    protected $childTag        = self::TAG_LIST_ITEM;
    protected $childAttributes = [];

    public function __construct(array $list = [], $attributes = [])
    {
        $this->items($list);
        $this->attributes($attributes);

        return $this;
    }

    public function items(array $items = [])
    {
        if ($items = $this->parseItems($items)) {
            $this->content($items);
        }

        return $this->content;
    }

    protected function parseItems(array $items)
    {
        if (isset($items['tag'])) {
            return [$items];
        } else {
            // Iterate trough provided items
            foreach ($items as $index => &$child) {
                // Check various child cases
                if (is_scalar($child)) {
                    // If child is scalar set it as simple li tag with string content
                    $child = $this->normalize($this->childTag, $child, $this->childAttributes);
                } elseif (is_array($child)) {
                    // if child is array means that list is nested
                    $child        = $this->normalize($this->childTag, $child, $this->childAttributes);
                    $childContent = $child['content'];
                    // If index is string set this as first content in nested list
                    // index could be string or instance of html element
                    if (is_string($index)) {
                        $child['content'] = [$index];
                    } elseif ($index instanceof TagAbstract) {
                        $child['content'] = [$index->toArray()];
                    }
                    // Set nested list recursive
                    $child['content'][] = new self($childContent);
                } elseif ($child instanceof TagAbstract) {
                    // Child is instance of html element, set element as array
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
        if (is_scalar($item)) {
            $item = [$item];
        }

        if ($items = $this->parseItems($item)) {
            $this->appendContent($items);
        }

        return $this->content;
    }

}