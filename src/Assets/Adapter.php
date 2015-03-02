<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 19:34
 */

namespace Bridge\Assets;

use Assetic\Asset\AssetCollection;
use Assetic\Asset\FileAsset;
use Assetic\Asset\GlobAsset;

class Adapter {

	protected $adapter = null;

	public function __construct()
	{
		$this->collection = new AssetCollection();
	}

}