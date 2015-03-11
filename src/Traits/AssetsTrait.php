<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 09.03.15.
 * Time: 18:52
 */

namespace Bridge\Traits;

use Bridge\Assets as AssetManager;

trait AssetsTrait
{
    protected function addAssets()
    {
        if (count($this->css)) {
            foreach ($this->css as $css) {
                AssetManager::addCssFile($this->checkParameters($css));
            }
        }

        if (count($this->js)) {
            foreach ($this->js as $js) {
                AssetManager::addJsFile($this->checkParameters($js));
            }
        }
    }

    public function checkParameters($asset)
    {
        $parameters = array('version');

        foreach ($parameters as $parameter) {
            $paramValue = $this->{$parameter};
            if (!empty($paramValue)) {
                $asset = str_replace("{@{$parameter}}", $this->{$parameter}, $asset);
            } else {
                throw new \RuntimeException(
                    sprintf("Failed to parse parameters in asset path. Parameter '%s' is empty", $parameter)
                );
            }
        }

        return $asset;
    }
}