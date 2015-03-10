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

class Libraries
{
    protected $libraries = [];

    public function __construct()
    {

    }

    protected function getList()
    {
        $list = [];

        // Iterate trough Libraries directory and found all libraries available
        foreach (new DirectoryIterator(Bridge::path('libraries')) as $classFile) {
            if (!$classFile->isFile()) {
                continue;
            }
            // Determine class name of library by filename
            $className = basename($classFile->getFilename(), '.php');
            // Skip defaults (Abstract and Interface)
            if (strpos($className, 'Abstract') == false && strpos($className, 'Interface') == false) {
                $list[] = $className;
            }
        }

        return $list;
    }

    public function registerLibraries()
    {
        if (empty($this->libraries)) {
            // Iterate trough available libraries list and create instance for each one
            foreach ($this->getList() as $library) {
                // Check for duplicates or same name libraries
                if (isset($this->libraries[$library])) {
                    throw new \LogicException(
                        sprintf("Failed to register libraries. Library with name %s already registered", $library)
                    );
                }
                // Check if library is properly loaded, if so, initialize library
                // and call register callback
                if (class_exists($class = 'Bridge\Libraries\\' . $library)) {
                    $instance = new $class();
                    $instance->register();
                    $this->libraries[$instance->getName()] = $instance;
                } else {
                    throw new \RuntimeException(
                        sprintf("Failed to register %s library. Class doesn't exists", $class)
                    );
                }
            }
        }

        return $this->libraries;
    }
}