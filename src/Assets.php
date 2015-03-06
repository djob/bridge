<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:12
 */
namespace Bridge;

use Bridge\Assets\Manager;
use Bridge\Assets\Adapter as AssetsAdapter;

class Assets
{
	public function __construct()
	{
		$this->manager = new Manager(new AssetsAdapter);
	}

	protected function __add($type, $path)
	{
		$this->manager->add($type, $path);
	}

	public function addCss($key)
	{

	}

	public function addJs($key)
	{

	}

}