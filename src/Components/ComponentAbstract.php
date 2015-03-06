<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 20:08
 */
namespace Bridge\Components;

use ReflectionMethod;
use Bridge\Html\TagAbstract;

abstract class ComponentAbstract implements ComponentInterface
{
    /**
     * @var \Bridge\Html\TagAbstract
     */
	protected $element;
    // Default attributes
    protected $attributes = [];

	public function __construct()
	{
        $reflection = new ReflectionMethod($this, 'init');
        $reflection->invokeArgs($this, func_get_args());

        $this->element->attributes($this->attributes);
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

    protected function beforeRender()
    {
    }

    protected function afterRender($html)
    {
        return $html;
    }

    public function render()
	{
		if ($this->element instanceof TagAbstract) {
            $this->beforeRender();

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