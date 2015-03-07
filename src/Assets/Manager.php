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

    private function addToCollection($collection, $data, $priority)
    {
        if (is_string($data)) {
            $this->append($collection, $data, $priority);
        } elseif (is_array($data)) {
            foreach ($data as $item) {
                $this->append($collection, $item, $priority);
            }
        } else {
            throw new \InvalidArgumentException(sprintf('Invalid argument provided (%s) to collection %s',
                gettype($data), $collection));
        }
    }

    protected function addFile($type, $path, $priority = 1)
    {
        $this->addToCollection($type . 'Files', $type, $priority);
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

}