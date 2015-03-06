<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 28.02.15.
 * Time: 11:47
 */

namespace Bridge\Assets;



class Manager {

    protected $adapter  = null;
    protected $cssFiles = [];
    protected $jsFiles  = [];
    protected $jsSources = [];
    protected $cssSources = [];

	public function __construct($adapter)
	{
		$this->adapter = $adapter;
	}

    private function append($collection, $path, $priority)
    {
        if (!isset($this->{$collection}[$path])) {
            $this->{$collection}[$path] = $priority;
        }
    }

    protected function addFile($type, $path, $priority = 1)
    {
        $collection = $type . 'Files';

        if (is_string($path)) {
            $this->append($collection, $path, $priority);
        } elseif (is_array($path)) {
            foreach ($path as $item) {
                $this->append($collection, $item, $priority);
            }
        }
    }

    protected function addSource($type, $source, $priority = 1)
    {
        $collection = $type . 'Sources';

        if (is_string($source)) {
            $this->append($collection, $source, $priority);
        } elseif (is_array($source)) {
            foreach ($source as $item) {
                $this->append($collection, $item, $priority);
            }
        }
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
        $this->addSource('js', $source, $priority);
    }

}