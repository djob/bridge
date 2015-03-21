<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 20:08
 */
namespace Bridge\Components;

use Bridge\Html\TagAbstract;
use Bridge\Traits\ReflectionMethodTrait;
use Bridge\Traits\SmartSetGetTrait;

abstract class ComponentAbstract implements ComponentInterface
{
    use ReflectionMethodTrait;
    use SmartSetGetTrait;

    protected $reflectionObject = 'element';
    /**
     * @var \Bridge\Html\TagAbstract
     */
    protected $element = null;
    // Default attributes
    protected $attributes = [];

    public function __construct()
    {
        // Call init in component main class if exists
        // Element must be always created in init method
        $this->reflectionMethodCall($this, 'init', func_get_args());

        if ($this->element) {
            $this->element->prependAttributes($this->attributes);

        } else {
            throw new \RuntimeException("Component element doesn't exists. Element instance must be created");
        }

        return $this;
    }

    public function element(TagAbstract $element = null)
    {
        return $this->smartGetSet('element', $element);
    }

    public function id($id = null)
    {
        if ($id) {
            $this->element->setAttribute('id', $id);
        }

        return $this->element->getAttribute('id');
    }

    public function elementClass($class = null)
    {
        if ($class) {
            $this->element->setAttribute('class', $class);
        }

        return $this->element->getAttribute('class');
    }

    public function appendClass($class)
    {
        return $this->element->appendAttribute('class', $class);
    }

    public function removeClass($class)
    {
        $this->element->removeAttribute('class', $class);
    }

    protected function beforeRender(TagAbstract $element)
    {
        return $element;
    }

    protected function afterRender($html)
    {
        return $html;
    }

    public function render()
    {
        if ($this->element instanceof TagAbstract) {
            $this->element = $this->beforeRender($this->element);

            $html = $this->element->render();
            $html = $this->afterRender($html);

            return $html;
        }

        throw new ComponentException('Cannot render component. Element is not instance of \Bridge\Html\TagAbstract');
    }

    public function __toString()
    {
        return $this->render();
    }
}