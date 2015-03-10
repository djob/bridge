<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 10.03.15.
 * Time: 06:24
 */

namespace Bridge\Utils;

use RuntimeException;

class Filesystem
{
    public static function writeFile($path, $content)
    {
        if (!is_dir(dirname($path))) {
            self::createDir($path);
        }

        if (false === @file_put_contents($path, $content)) {
            throw new RuntimeException('Failed to write to file ' . $path);
        }
    }

    public static function saveRemote($url, $path)
    {
        $fp = self::fopenHandle($path);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        $response = curl_exec($ch);
        fclose($fp);

        if ($response == false) {
            throw new RuntimeException(
                sprintf('Unable to save remote file %s to %s. Curl error: %s', $url, $path, curl_error($ch))
            );
        }

        curl_close($ch);

        return $path;
    }

    public static function fileExists($file)
    {
        return file_exists($file) && is_readable($file);
    }

    public static function dirExists($path)
    {
        return is_writable(dirname($path));
    }

    public static function fopenHandle($path, $mode = 'w+')
    {
        if ($fp = @fopen($path, $mode)) {
            return $fp;
        }

        throw new RuntimeException(sprintf('Failed to open file "%s" with mode "%s"', $path, $mode));
    }

    public static function tempPath()
    {
        return realpath(sys_get_temp_dir());
    }

    public static function createDir($path)
    {
        if (false === @mkdir($path, 0775, true)) {
            throw new RuntimeException("Failed to create directory");
        }

        return $path;
    }
}