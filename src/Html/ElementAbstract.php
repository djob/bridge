<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:13
 */
namespace Bridge\Html;

abstract class ElementAbstract implements ElementInterface
{
    protected $content    = null;
    protected $tagName    = null;
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
     * @param array|ElementAbstract $content
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

    public function tagName($tagName = null)
    {
        return $this->smartGetSet('tagName', $tagName);
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
            foreach ($content as $item) {
                $this->content[] = $item;
            }
        } else {
            $this->content[] = $content;
        }

        return $this->content;
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

}