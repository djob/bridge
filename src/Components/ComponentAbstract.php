<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 20:08
 */

namespace Bridge\Components;

use Bridge\Html\Tag;

abstract class ComponentAbstract implements ComponentInterface
{
	protected $element;

	public function __construct()
	{

	}

	public function render()
	{
		if ($this->element) {
			return $this->element->render();
		}
	}

	public function __toString()
	{
		return $this->render();
	}

}