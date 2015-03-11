<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 28.02.15.
 * Time: 11:47
 */

namespace Bridge\Assets;

use Bridge\Config;
use Bridge\Utils\Filesystem;
use RuntimeException;
use InvalidArgumentException;

class Manager
{
    protected $adapter           = null;
    protected $cssFiles          = [];
    protected $jsFiles           = [];
    protected $jsSources         = [];
    protected $cssSources        = [];
    public $allowedExtensions    = ['css', 'js'];

    public function __construct($adapter)
    {
        $this->setAdapter($adapter);
        $this->cdn = new Cdn($this);
    }

    public function setAdapter($adapter)
    {
        if (!is_object($adapter)) {
            throw new InvalidArgumentException('Invalid adapter provided to Assets\Manager.');
        }

        $this->adapter = $adapter;
        $this->adapter->setManager($this);
    }

    private function checkCdn(array $files)
    {
        foreach ($files as $key => $data) {
            if ($this->cdn->isRemote($data['path'])) {
                $files[$key]['path'] = $this->cdn->save($data['path']);
            }
        }

        return $files;
    }

    public function getAssetsPath($append = null)
    {
        if ($path = Config::get('assets_path')) {
            if (Filesystem::dirExists($path)) {
                return rtrim($path, '\/') . (($append !== null) ? '\\' . $append : '');
            } else {
                throw new RuntimeException(
                    sprintf("Assets path is defined as %s, but not exists or not writable!", $path)
                );
            }
        }

        return rtrim(Filesystem::tempPath(), '\/') . (($append !== null) ? '\\' . $append : '');
    }

    private function append($collection, $path, $priority)
    {
        if (!isset($this->{$collection}[$path])) {
            $this->{$collection}[$path] = [
                'path'     => $path,
                'priority' => $priority
            ];
        }

        return $collection;
    }

    private function addToCollection($collection, $data, $priority)
    {
        if (is_string($data)) {
            $this->append($collection, $data, $priority);
        } elseif (is_array($data)) {
            foreach ($data as $item) {
                $this->append($collection, $item, $priority);
            }
        } else {
            throw new \InvalidArgumentException(
                sprintf('Invalid argument provided (%s) to collection %s', gettype($data), $collection)
            );
        }
    }

    protected function addFile($type, $path, $priority = 1)
    {
        $this->addToCollection($type . 'Files', $path, $priority);
    }

    protected function addSource($type, $source, $priority = 1)
    {
        $this->addToCollection($type . 'Sources', $source, $priority);
    }

    public function addCssFile($path, $priority = 1)
    {
        $this->addFile('css', $path, $priority);
    }

    public function addJsFile($path, $priority = 1)
    {
        $this->addFile('js', $path, $priority);
    }

    public function addJsSource($source, $priority = 1)
    {
        $this->addSource('js', $source, $priority);
    }

    public function addCssSource($source, $priority = 1)
    {
        $this->addSource('css', $source, $priority);
    }

    public function dumpCss()
    {
        if ($path = $this->adapter->getCss($this->checkCdn($this->cssFiles))) {
            return $path;
        }
    }

    public function dumpJs()
    {
        if ($path = $this->adapter->getJs($this->checkCdn($this->jsFiles))) {
            return $path;
        }
    }

    public function css($baseUrl = null)
    {
        if ($file = $this->dumpCss()) {
            return $baseUrl ? $baseUrl . '\\' . $file : $file;
        }

        throw new RuntimeException('Unable to resolve css path');
    }

    public function js($baseUrl = null)
    {
        if ($file = $this->dumpJs()) {
            return $baseUrl ? $baseUrl . '\\' . $file : $file;
        }

        throw new RuntimeException('Unable to resolve js path');
    }

}