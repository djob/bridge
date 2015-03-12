<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 12.03.15.
 * Time: 06:52
 */

namespace Bridge\Skins\Bootstrap;

use Bridge\Components\ComponentAbstract;
use Bridge\Html\Tag;

class Lead extends ComponentAbstract
{
    const TAG_LEAD = 'p';
    const CLASS_LEAD = 'lead';

    public function init($content, array $attributes = [])
    {
        $this->element(new Tag(self::TAG_LEAD, $content, array_merge_recursive([
            'class' => self::CLASS_LEAD
        ], $attributes)));

        return $this;
    }
}