<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 02.03.15.
 * Time: 19:34
 */

namespace Bridge\Assets;

use Assetic\Asset\AssetCollection;
use Assetic\AssetManager;
use Assetic\AssetWriter;
use Assetic\Asset\FileAsset;
use Bridge\Utils\Filesystem;

class Adapter
{

    protected $adapter = null;
    protected $manager = null;

    public function __construct()
    {

    }

    public function setManager(\Bridge\Assets\Manager $manager)
    {
        $this->manager = $manager;
    }

    private function getCollection($files)
    {
        $collection = [];

        foreach ($files as $file) {
            $collection[] = new FileAsset($file['path']);
        }

        return new AssetCollection($collection);
    }

    private function write(AssetCollection $collection, $id, $filename, $filepath)
    {
        $am = new AssetManager();
        $collection->setTargetPath($filename);
        $am->set($id, $collection);
        $writer = new AssetWriter($filepath);
        $writer->writeManagerAssets($am);
    }

    private function dump($type, $files)
    {
        $id       = md5(json_encode($files));
        $filename = $id . '.' . $type;
        $path     = $this->manager->getAssetsPath();
        $filepath = $path . '\\' . $filename;

        if (Filesystem::fileExists($filepath)) {
            return $filepath;
        }

        $collection = $this->getCollection($files);
        $this->write($collection, $type . '_' . $id, $filename, $path);

        return $filepath;
    }

    public function getCss($files)
    {
        return $this->dump('css', $files);
    }

    public function getJs($files)
    {
        return $this->dump('js', $files);
    }


}