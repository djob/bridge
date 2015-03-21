<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:13
 */
namespace Bridge\Html;

use Bridge\Traits\SmartSetGetTrait;

abstract class TagAbstract
{
    use SmartSetGetTrait;

    // Table tags constants
    const TAG_TABLE = 'table';
    const TAG_TBODY = 'tbody';
    const TAG_THEAD = 'thead';
    const TAG_TFOOT = 'tfoot';
    const TAG_TR    = 'tr';
    const TAG_TD    = 'td';
    const TAG_TH    = 'th';
    // List tags
    const TAG_LIST          = 'ul';
    const TAG_LIST_ORDERED  = 'ol';
    const TAG_LIST_ITEM     = 'li';
    const TAG_LIST_DESC     = 'dl';
    const TAG_LIST_DESC_KEY = 'dt';
    const TAG_LIST_DESC_VAL = 'dd';
    // Interaction tags constants
    const TAG_BUTTON = 'button';
    // Form tags
    const TAG_FORM     = 'form';
    const TAG_INPUT    = 'input';
    const TAG_SELECT   = 'select';
    const TAG_OPTION   = 'option';
    const TAG_OPTGROUP = 'optgroup';
    const TAG_TEXTAREA = 'textarea';
    const TAG_LABEL    = 'label';
    const TAG_FIELDSET = 'fieldset';
    const TAG_LEGEND   = 'legend';

    protected $content    = null;
    protected $name       = null;
    protected $attributes = [];

    protected $builder = null;

    // @TODO - get builder as singelton
    public function getBuilder()
    {
        if (!$this->builder) {
            $this->builder = new Builder();
        }

        return $this->builder;
    }

    protected function normalize($tag, $element, array $attributes = [])
    {
        if (is_array($element)) {
            $element = [
                'tag'        => $tag,
                'content'    => isset($element['content']) ? $element['content'] : $element,
                'attributes' => isset($element['attributes']) ? $element['attributes'] : $attributes
            ];

            return $element;
        } elseif ($element instanceof TagAbstract) {
            return $element->toArray();
        } elseif (is_scalar($element)) {
            return [
                'tag'        => $tag,
                'content'    => $element,
                'attributes' => $attributes
            ];
        } else {
            throw new \InvalidArgumentException(
                sprintf("Unable to normalize tag. Invalid element type provided %s.", gettype($element))
            );
        }
    }

    /**
     * Set or get content of element
     *
     * @param array|TagAbstract $content
     * @return array
     */
    public function content($content = null)
    {
        return $this->smartGetSet('content', $content);
    }

    public function attributes(array $attributes = [])
    {
        return $this->smartGetSet('attributes', $attributes);
    }


    public function removeAttribute($attribute, $value = null)
    {
        if (isset($this->attributes[$attribute])) {
            if ($value) {
                if (is_string($this->attributes[$attribute]) && !empty($this->attributes[$attribute])) {
                    if (is_string($value)) {
                        $this->attributes[$attribute] = str_replace($value, '', $this->attributes[$attribute]);
                    } elseif (is_array($value)) {
                        foreach ($value as $val) {
                            $this->attributes[$attribute] = str_replace($val, '', $this->attributes[$attribute]);
                        }
                    }
                } elseif (is_array($this->attributes[$attribute]) && count($this->attributes[$attribute])) {
                    if (is_string($value)) {
                        if ($index = array_search($value, $this->attributes[$attribute])) {
                            unset($this->attributes[$attribute][$index]);
                        }
                    } elseif (is_array($value)) {
                        foreach ($value as $val) {
                            if ($index = array_search($val, $this->attributes[$attribute])) {
                                unset($this->attributes[$attribute][$index]);
                            }
                        }
                    }
                }

                return $this->attributes[$attribute];
            } else {
                unset ($this->attributes[$attribute]);
            }
        }

        return null;
    }

    public function appendAttribute($attribute, $value)
    {
        $this->checkAttribute($attribute);

        if (!in_array($value, $this->attributes[$attribute])) {
            if (is_scalar($value)) {
                $this->attributes[$attribute][] = $value;
            } elseif (is_array($value)) {
                foreach ($value as $val) {
                    $this->attributes[$attribute][] = $val;
                }
            } else {
                throw new \InvalidArgumentException(
                    sprintf('Unable to append to attribute %s. Provided value invalid type!', $attribute)
                );
            }

        }
    }

    public function prependAttribute($attribute, $value)
    {
        $this->checkAttribute($attribute);

        if (!in_array($value, $this->attributes[$attribute])) {
            if (is_scalar($value)) {
                array_unshift($this->attributes[$attribute], $value);
            } elseif (is_array($value)) {
                foreach ($value as $val) {
                    array_unshift($this->attributes[$attribute], $val);
                }
            } else {
                throw new \InvalidArgumentException(
                    sprintf('Unable to prepend to attribute %s. Provided value invalid type!', $attribute)
                );
            }
        }
    }

    public function appendAttributes(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->appendAttribute($attribute, $value);
        }

        return $this->attributes();
    }

    public function prependAttributes(array $attributes)
    {
        foreach ($attributes as $attribute => $value) {
            $this->prependAttribute($attribute, $value);
        }

        return $this->attributes();
    }

    public function setAttribute($attribute, $value)
    {
        $this->attributes[$attribute] = [$value];
    }

    public function getAttribute($attribute)
    {
        if (isset($this->attributes[$attribute])) {
            return $this->attributes[$attribute];
        }

        return null;
    }

    protected function checkAttribute($attribute)
    {
        if (!isset($this->attributes[$attribute])) {
            $this->attributes[$attribute] = [];
        } elseif (!is_array($this->attributes[$attribute])) {
            $this->attributes[$attribute] = [$this->attributes[$attribute]];
        }
    }

    public function name($name = null)
    {
        return $this->smartGetSet('name', $name);
    }

    public function normalizeContent()
    {
        if (empty($this->content)) {
            return $this->content = [];
        }

        if (!is_array($this->content)) {
            $this->content = [$this->content];
        }

        return $this->content;
    }

    /**
     * Append to content
     *
     * @return array
     */
    public function appendContent($content)
    {
        $this->normalizeContent();

        if (is_array($content)) {
            if (isset($content['tag'])) {
                $this->content[] = $content;
            } else {
                foreach ($content as $cnt) {
                    $this->appendContent($cnt);
                }
            }

        } else {
            $this->content[] = $content;
        }

        return $this->content;
    }

    /**
     * Renders Html element
     *
     * @use Djob\Bridge\Html\Renderer
     * @return string
     */
    public function render()
    {
        return $this->getBuilder()->build($this);
    }

    public function contentToArray($content)
    {
        if ($content instanceof TagAbstract) {
            return $content->toArray();
        }

        if (is_array($content)) {
            if (isset($content['content'])) {
                $content['content'] = $this->contentToArray($content['content']);
            } else {
                foreach ($content as &$child) {
                    $child = $this->contentToArray($child);
                }
            }
        }


        return $content;
    }

    /**
     * Output Html Tag\Abstract object as html
     *
     * @return array
     * */
    public function toArray()
    {
        $array = [
            'tag'        => $this->name(),
            'attributes' => $this->attributes(),
            'content'    => $this->contentToArray($this->content())
        ];

        return $array;
    }

    /**
     * Alias of self::render()
     *
     * @return string
     * */
    public function __toString()
    {
        return $this->render();
    }

}