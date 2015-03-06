<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:12
 */
namespace Bridge;

use Bridge\Assets\Manager as AssetsManager;
use Bridge\Assets\Adapter as AssetsAdapter;
use Bridge\Components\ComponentFactory;
use Bridge\Skins\SkinAbstract;
use Bridge\Skins\Bootstrap;

class Bridge {

	private static $instance = null;
    private $skin = null;
    private $assetManager = null;

	public function __construct(SkinAbstract $skin = null)
	{
        // If skin is not defined, use Bootstrap as default
        if (!$skin) {
            $this->skin = new Bootstrap();
        }

        // Set asset manager
        $this->assetManager = new AssetsManager(new AssetsAdapter());
	}

    public function assets()
    {
        return $this->assetManager;
    }

	public static function getInstance()
	{
		if (! self::$instance) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function __callStatic($name, $arguments)
	{
		return ComponentFactory::make($name, $arguments, self::getInstance()->skin);
	}

	public function component($name)
	{
		$arguments = func_get_args();
		array_shift($arguments);
		return ComponentFactory::make($name, $arguments, $this->skin);
	}
}