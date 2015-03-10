<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 07.03.15.
 * Time: 07:41
 */

namespace Bridge\Assets;

use Bridge\Utils\Filesystem;
use InvalidArgumentException;

class Cdn
{
    protected $manager = null;

    public function __construct(\Bridge\Assets\Manager $manager)
    {
        $this->manager = $manager;
    }

    public function save($url)
    {
        $url = $this->checkUrl($url);
        $info = pathinfo($url);

        if (!isset($info['extension']) && !in_array($info['extension'], $this->manager->allowedExtensions)) {
            throw new InvalidArgumentException(sprintf('Provided url "%s" is not valid file.', $url));
        }

        $path = $this->manager->getAssetsPath(md5($url) . '.' . $info['extension']);

        if (Filesystem::fileExists($path)) {
            return $path;
        }

        return Filesystem::saveRemote($url, $path);
    }

    public function checkUrl($url)
    {
        if (substr($url, 0, 2) == '//') {
            $url = ltrim($url, '//');
        }

        return $url;
    }

    public function isRemote($url)
    {
        $url = 'http://' . str_replace(['http://', 'https://', '//',], '', $url);
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }
}