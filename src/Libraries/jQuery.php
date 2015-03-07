<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 06.03.15.
 * Time: 18:58
 */

namespace Bridge\Libraries;


class jQuery extends LibraryAbstract{
    protected $name = 'jquery';
    protected $version = '2.1.1';
    protected $js = [
        'jquery' => '//ajax.googleapis.com/ajax/libs/jquery/{@version}/jquery.min.js'
    ];
}