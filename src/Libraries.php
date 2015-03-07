<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 06.03.15.
 * Time: 19:03
 */

namespace Bridge;

use Bridge\Bridge;
use DirectoryIterator;

class Libraries {
    protected $libraries = [];

    protected function getList()
    {
        $list = [];

        foreach (new DirectoryIterator(Bridge::path('libraries')) as $classFile) {
            if (!$classFile->isFile()) {
                continue;
            }
            $className = basename($classFile->getFilename(), '.php');

            if (strpos($className, 'Abstract') == false && strpos($className, 'Interface') == false) {
                $list[] = $className;
            }
        }

        return $list;
    }

    public function registerLibraries()
    {
        if (empty($this->libraries)) {
            foreach ($this->getList() as $library) {
                if(class_exists($class = 'Bridge\Libraries\\' . $library)) {
                    $instance = new $class();
                    $this->libraries[$instance->getName()] = $instance;
                } else {
                    throw new \RuntimeException(sprintf('Failed to register %s library. Class doesn\'t exists', $class));
                }
            }
        }

        return $this->libraries;
    }
}