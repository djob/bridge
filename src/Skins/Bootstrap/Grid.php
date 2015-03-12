<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 07.03.15.
 * Time: 11:17
 */

namespace Bridge\Skins\Bootstrap;

use Bridge\Components\Grid as GridDefault;
use Bridge\Html\Tag;

class Grid extends GridDefault
{
    // Style classes
    const CLASS_STRIPED   = 'table-striped';
    const CLASS_BORDERED  = 'table-bordered';
    const CLASS_HOVER     = 'table-hover';
    const CLASS_CONDENSED = 'table-condensed';
    // Layout classes
    const CLASS_RESPONSIVE = 'table-responsive';

    protected $attributes  = [
        'class' => 'table'
    ];

    protected function resetStyle()
    {
        $this->removeClass([

        ]);
    }

    public function striped()
    {
        $this->appendClass(self::CLASS_STRIPED);
        return $this;
    }

    public function bordered()
    {
        $this->appendClass(self::CLASS_BORDERED);
        return $this;
    }

    public function hover()
    {
        $this->appendClass(self::CLASS_HOVER);
        return $this;
    }

    public function condensed()
    {
        $this->appendClass(self::CLASS_CONDENSED);
        return $this;
    }

    public function responsive()
    {
        $this->element(new Tag('div', $this->element, [
            'class' => self::CLASS_RESPONSIVE
        ]));
        return $this;
    }

}