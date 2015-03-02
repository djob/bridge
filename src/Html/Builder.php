<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 28.02.15.
 * Time: 14:27
 */

namespace Bridge\Html;

class Builder {

	public function __construct()
	{

	}

	public function tag(array $element)
	{
		$html = '<' . $element['tag'];

		if ($attributes = $this->attributes(isset($element['attributes']) ? $element['attributes'] : [])) {
			$html .= $attributes;
		}

		if ($content = $this->content(isset($element['content']) ? $element['content'] : [])) {
			$html .= '>' . $content . '</' . $element['tag'] . '>';
		} else {
			$html .= '/>';
		}

		return $html;
	}

	public function attributes(array $attributes)
	{
		$html = '';

		if (count($attributes)) {
			foreach ($attributes as $key => $val) {
				$html .= ' ' . $key . '=' . $val;
			}
		}

		return $html;
	}

	/**
	 * @param array $content [
	 *      'tag' => 'tagnamae'
	 *   ...
	 * ]
	 * array $content = [
	 *      [
	 *         'tag' => 'tagname',
	 *      ],
	 *      []
	 *      ...
	 * ]
	 * string $content
	 * @return string
	 */
	public function content($content)
	{
		$html = '';

		if (is_array($content) && count($content)) {
			if (isset($content['tag'])) {
				$html .= $this->tag($content);
			} else {
				foreach ($content as $child) {
					$html .= $this->tag($child);
				}
			}

		} elseif (is_scalar($content)) {
			$html .= $content;
		} elseif ($content instanceof ElementAbstract) {
			$html .= $content;
		}

		return $html;
	}

	public function build($element)
	{
		if ($element instanceof ElementAbstract) {
			$element = $element->toArray();
		} elseif (!is_array($element)) {
			throw new ElementException('Cannot build html string. Invalid argument provided.');
		}

		return $this->tag($element);
	}
}