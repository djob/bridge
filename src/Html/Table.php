<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:59
 */
namespace Bridge\Html;

class Table extends TagAbstract
{
    protected $name   = self::TAG_TABLE;
    protected $body   = [];
    protected $header = [];
    protected $footer = [];

    public function __construct(array $body = [], array $header = [], array $footer = [], array $attributes = [])
    {
        $this->body($body);
        $this->header($header);
        $this->footer($footer);
        $this->attributes($attributes);
    }

    public function header(array $header = [])
    {
        if (count($header)) {
            $tr = $this->normalize(self::TAG_TR, $header);

            foreach ($tr['content'] as $key => $td) {
                $tr['content'][$key] = $this->normalize(self::TAG_TH, $td);
            }

            $header = [
                'tag'     => self::TAG_THEAD,
                'content' => $tr
            ];
            $this->appendContent($header);

            $this->header = $header;
        }

        return $this->header;
    }

    public function footer(array $footer = [])
    {
        if (count($footer)) {
            $tr = $this->normalize(self::TAG_TR, $footer);

            foreach ($tr['content'] as $key => $td) {
                $tr['content'][$key] = $this->normalize(self::TAG_TD, $td);
            }

            $footer = $this->normalize(self::TAG_TFOOT, $tr);

            $this->appendContent($footer);
            $this->footer = $footer;
        }

        return $this->footer;
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
                    $tr = $this->normalize(self::TAG_TR, $tr);
                    foreach ((array)$tr['content'] as $key => &$td) {
                        $tr['content'][$key] = $this->normalize(self::TAG_TD, $td);
                    }
                } else {
                    throw new TagException(
                        'Invalid body content provided for Table element. Row must be array of columns'
                    );
                }
            }
            $body = $this->normalize(self::TAG_TBODY, $body);
            $this->appendContent($body);

            $this->body = $body;
        }

        return $this->body;
    }
}