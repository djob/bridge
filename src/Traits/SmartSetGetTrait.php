<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 12.03.15.
 * Time: 06:32
 */

namespace Bridge\Traits;

trait SmartSetGetTrait
{
    protected function smartGetSet($attribute, $value)
    {
        if (!empty($value)) {
            $this->{$attribute} = $value;
        }

        return $this->{$attribute};
    }
}