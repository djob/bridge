<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:59
 */
namespace Bridge\Html;

use Bridge\Traits\SmartSetGetTrait;

class Table extends TagAbstract
{
    use SmartSetGetTrait;

    protected $name   = self::TAG_TABLE;
    protected $trAttr = [];
    protected $tdAttr = [];
    protected $thAttr = [];

    public function __construct(array $body = [], array $header = [], array $footer = [], array $attributes = [])
    {
        $this->body($body);
        $this->header($header);
        $this->footer($footer);
        $this->attributes($attributes);

        return $this;
    }

    public function trAttr(array $attributes = [])
    {
        return $this->smartGetSet('trAttr', $attributes);
    }

    public function tdAttr(array $attributes = [])
    {
        return $this->smartGetSet('tdAttr', $attributes);
    }

    public function thAttr(array $attributes = [])
    {
        return $this->smartGetSet('thAttr', $attributes);
    }

    public function header(array $header = [])
    {
        if (count($header)) {
            $tr = $this->normalize(self::TAG_TR, $header);

            foreach ($tr['content'] as $key => $td) {
                $tr['content'][$key] = $this->normalize(self::TAG_TH, $td, $this->thAttr);
            }

            $header = [
                'tag'     => self::TAG_THEAD,
                'content' => $tr
            ];
            $this->appendContent($header);
        }

        return $this;
    }

    public function footer(array $footer = [])
    {
        if (count($footer)) {
            $tr = $this->normalize(self::TAG_TR, $footer);

            foreach ($tr['content'] as $key => $td) {
                $tr['content'][$key] = $this->normalize(self::TAG_TD, $td, $this->tdAttr);
            }

            $footer = $this->normalize(self::TAG_TFOOT, $tr, $this->trAttr);

            $this->appendContent($footer);
        }

        return $this;
    }


    /**
     * Set body part of table
     *
     * @param array $body
     * @return array
     * @throws TagException
     */
    public function body(array $body = [])
    {
        if (count($body)) {
            // Iterate trough body data and convert it to tag element format
            foreach ($body as &$tr) {
                // Check if item of array is array;
                if (is_array($tr)) {
                    $tr = $this->normalize(self::TAG_TR, $tr, $this->trAttr);
                    foreach ((array)$tr['content'] as $key => &$td) {
                        $tr['content'][$key] = $this->normalize(self::TAG_TD, $td, $this->tdAttr);
                    }
                } else {
                    throw new TagException(
                        'Invalid body content provided for Table element. Row must be array of columns'
                    );
                }
            }
            $body = $this->normalize(self::TAG_TBODY, $body);
            $this->appendContent($body);
        }

        return $this;
    }
}