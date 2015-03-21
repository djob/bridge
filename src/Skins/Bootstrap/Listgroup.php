<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 12.03.15.
 * Time: 20:17
 */

namespace Bridge\Skins\Bootstrap;

use Bridge\Components\Listing;

class Listgroup extends Listing
{
    const CLASS_LIST_GROUP      = 'list-group';
    const CLASS_LIST_GROUP_ITEM = 'list-group-item';

    protected $attributes = [
        'class' => [self::CLASS_LIST_GROUP]
    ];

    protected $childAttributes = [
        'class' => [self::CLASS_LIST_GROUP_ITEM]
    ];
}