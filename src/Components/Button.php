<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 21:17
 */

namespace Bridge\Components;

use Bridge\Html\Tag;

class Button extends ComponentAbstract
{
	public function init($content = null, $attributes = [])
	{
		$this->element = new Tag('button', $content, $attributes);
	}
}