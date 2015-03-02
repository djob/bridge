<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 21:17
 */

namespace Bridge\Components;

use Bridge\Html\Tag;

class Button extends ComponentAbstract{

	public function init()
	{

	}

	public function render()
	{
		$element = new Tag('button', 'CLick ME', array(
			'class' => 'btn btn-primary'
		));

		return $element->render();
	}
}