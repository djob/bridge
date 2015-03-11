<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 28.02.15.
 * Time: 14:27
 */

namespace Bridge\Html;

class Builder
{

    public function __construct()
    {

    }

    /**
     * Build tag string
     *
     * @param array $element
     * @return string
     */
    public function tag(array $element)
    {
        $html = '<' . $element['tag'];

        if ($attributes = $this->attributes(isset($element['attributes']) ? $element['attributes'] : [])) {
            $html .= $attributes;
        }

        if ($content = $this->content(isset($element['content']) ? $element['content'] : [])) {
            $html .= '>' . $content . '</' . $element['tag'] . '>';
        } else {
            $html .= '/>';
        }

        return $html;
    }


    /**
     * Build attributes string
     *
     * @param array $attributes
     * @return string
     */
    public function attributes(array $attributes)
    {
        $html = '';

        if (count($attributes)) {
            foreach ($attributes as $key => $val) {
                $html .= " {$key}=\"";
                if (is_array($val)) {
                    $html .= implode(' ', $val) . '"';
                } else {
                    $html .= $val . '"';
                }
            }
        }

        return $html;
    }

    /**
     * Build content string
     *
     * @param mixed $content
     * @return string
     */
    public function content($content)
    {
        $html = '';

        if (is_array($content) && count($content)) {
            if (isset($content['tag'])) {
                $html .= $this->tag($content);
            } else {
                foreach ($content as $child) {
                    if (is_scalar($child)) {
                        $html .= $child;
                    } else {
                        $html .= $this->tag($child);
                    }
                }
            }
        } elseif (is_scalar($content) || $content instanceof TagAbstract) {
            $html .= $content;
        } else {
            return null;
            #throw new TagException('Cannot build html string. Invalid content provided.');
        }

        return $html;
    }


    /**
     * Build complete tag string
     *
     * @param $element
     * @return null|string
     */
    public function build($element)
    {
        if ($element instanceof TagAbstract) {
            $element = $element->toArray();
        } elseif (!is_array($element)) {
            return null;
            #throw new TagException('Cannot build html string. Invalid argument provided.');
        }

        return $this->tag($element);
    }
}