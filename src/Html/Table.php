<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 10:59
 */
namespace Djob\Bridge\Html;

class Table extends ElementAbstract
{
	protected $tagName = 'table';
	protected $body    = [];
	protected $header  = [];
	protected $footer  = [];

	public function __construct(array $body = [], array $header = [], array $footer = [])
	{
		$this->body($body);
		$this->header($header);
		$this->footer($footer);
	}

	public function header(array $header = [])
	{
		if ($header && is_array($header)) {
			$header = new Element('thead', array(), $header);
		}

		return $this->smartGetSet('header', $header);
	}

	public function footer(array $footer = [])
	{
		if ($footer && is_array($footer)) {
			$footer = new Element('tfoot', array(), $footer);
		}

		return $this->smartGetSet('footer', $footer);
	}

	public function body(array $body = [])
	{
		if ($body && is_array($body)) {
			foreach ($body as &$tr) {
				if (is_array($tr)) {

					$tr = $this->normalize('tr', $tr);

					foreach ((array) $tr['content'] as $key => &$td) {
						$tr['content'][$key] = $this->normalize('td', $td);
					}

				} else {
					throw new ElementException('Invalid body content provided for Table element. Row must be array of columns');
				}
			}

			$body = $this->normalize('tbody', $body);
		}

		return $this->body = $this->content($body);
	}
}