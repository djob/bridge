<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 05.03.15.
 * Time: 06:30
 */
namespace Bridge\Skins\Bootstrap;

use Bridge\Components\Button as DefaultButton;

class Button extends DefaultButton
{
    const CLASS_BTN = 'btn';
    // Style classes
    const CLASS_DEFAULT = 'btn-default';
    const CLASS_PRIMARY = 'btn-primary';
    const CLASS_SUCCESS = 'btn-success';
    const CLASS_INFO    = 'btn-info';
    const CLASS_WARNING = 'btn-warning';
    const CLASS_DANGER  = 'btn-danger';
    const CLASS_LINK    = 'btn-link';
    // Size classes
    const CLASS_LARGE  = 'btn-lg';
    const CLASS_SMALL  = 'btn-sm';
    const CLASS_XSMALL = 'btn-xs';
    // Structure classes
    const CLASS_BLOCK = 'btn-block';
    // States classes
    const CLASS_ACTIVE = 'btn-active';
    // For a elements
    const CLASS_DISABLED = 'disabled';
    // For button elements
    const ATTR_DISABLED = ['disabled' => 'disabled'];

    protected $attributes = [
        'class' => self::CLASS_BTN
    ];

    protected function resetStyle()
    {
        $this->removeClass([
            self::CLASS_DEFAULT,
            self::CLASS_PRIMARY,
            self::CLASS_SUCCESS,
            self::CLASS_INFO,
            self::CLASS_WARNING,
            self::CLASS_DANGER,
            self::CLASS_LINK
        ]);
    }

    protected function resetSize()
    {
        $this->removeClass([
            self::CLASS_LARGE,
            self::CLASS_SMALL,
            self::CLASS_XSMALL
        ]);
    }

    public function primary()
    {
        $this->resetStyle();
        $this->appendClass(self::CLASS_PRIMARY);
        return $this;
    }

    public function btnDefault()
    {
        $this->resetStyle();
        $this->appendClass(self::CLASS_DEFAULT);
        return $this;
    }

    public function success()
    {
        $this->resetStyle();
        $this->appendClass(self::CLASS_SUCCESS);
        return $this;
    }

    public function info()
    {
        $this->resetStyle();
        $this->appendClass(self::CLASS_INFO);
        return $this;
    }

    public function warning()
    {
        $this->resetStyle();
        $this->appendClass(self::CLASS_WARNING);
        return $this;
    }

    public function danger()
    {
        $this->resetStyle();
        $this->appendClass(self::CLASS_DANGER);
        return $this;
    }

    public function link()
    {
        $this->resetStyle();
        $this->appendClass(self::CLASS_LINK);
        return $this;
    }

    public function large()
    {
        $this->resetSize();
        $this->appendClass(self::CLASS_LARGE);
        return $this;
    }

    public function small()
    {
        $this->resetSize();
        $this->appendClass(self::CLASS_SMALL);
        return $this;
    }

    public function xsmall()
    {
        $this->resetSize();
        $this->appendClass(self::CLASS_XSMALL);
        return $this;
    }

    public function normal()
    {
        $this->resetSize();
        return $this;
    }
}