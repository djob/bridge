<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:13
 */
namespace Djob\Bridge\Html;

abstract class ElementAbstract implements ElementInterface
{
    protected $content    = null;
    protected $tagName    = null;
    protected $attributes = [];

    protected final function smartGetSet($attribute, $value)
    {
        if (!empty($value)) {
            $this->{$attribute} = $value;
        }

        return $this->{$attribute};
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
        $renderer = new Renderer($this);
        return $renderer->render();
    }

}