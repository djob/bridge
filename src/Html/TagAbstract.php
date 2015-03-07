<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:13
 */
namespace Bridge\Html;

abstract class TagAbstract
{
	// Table tags constants
	const TAG_TBODY = 'tbody';
	const TAG_THEAD = 'thead';
	const TAG_TFOOT = 'tfoot';
	const TAG_TR    = 'tr';
	const TAG_TD    = 'td';
	const TAG_TH    = 'th';
	// Interaction tags constants
	const TAG_BUTTON = 'button';

    protected $content    = null;
    protected $name    = null;
    protected $attributes = [];

	protected $builder = null;

    protected final function smartGetSet($attribute, $value)
    {
        if (!empty($value)) {
            $this->{$attribute} = $value;
        }

        return $this->{$attribute};
    }

	public function getBuilder()
	{
		if (!$this->builder) {
			$this->builder = new Builder();
		}

		return $this->builder;
	}

	protected function normalize($tag, $element, array $attributes = []) {
		if (is_array($element)) {
			if (!isset($element['content'])) {
				$element = [
					'tag' => $tag,
					'content' => $element,
					'attributes' => $attributes
				];
			}

			return $element;
		} else {
			return [
				'tag' => $tag,
				'content' => $element,
				'attributes' => $attributes
			];
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
            $this->attributes[$attribute][] = $value;
        }
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

    public function contentToArray()
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
        $this->contentToArray();

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

	/**
	 * Alias of self::render()
	 *
	 * @return string
	 * */
	public function toArray()
	{
		$array = [
			'tag' => $this->name(),
			'attributes' => $this->attributes(),
			'content' => $this->content()
		];

		if (is_array($array['content'])) {
			foreach ($array['content'] as &$child) {
				if ($child instanceof TagAbstract) {
					$child = $child->toArray();
				}
			}
		}

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