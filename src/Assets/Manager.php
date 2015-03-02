<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 28.02.15.
 * Time: 11:47
 */

namespace Bridge\Assets;



class Manager {

	protected $adapter = null;
	protected $cssCollection = array();
	protected $jsCollection = array();

	public function __construct($adapter)
	{
		$this->adapter = $adapter;
	}

}