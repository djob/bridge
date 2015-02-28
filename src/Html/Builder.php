<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 14:30
 */
namespace Djob\Bridge\Html;

class Builder
{
	/**
	 * Element object
	 *
	 * @param ElementAbstract
	 */
	protected $element;

	/**
	 * Initialize Html Builder class
	 *
	 */
	public function __construct()
	{
	}

	protected function buildAttributes(array $attributes)
	{
		$html = '';
		foreach ($attributes as $attributeName => $attributeValue) {
			$html .= " {$attributeName}=\"{$attributeValue}\"";
		}

		return $html;
	}

	private function elementBuilder($element)
	{
		$html = '';

		if (is_array($element)) {
			if (isset($element['content'])) {

				$html = '<' . $element['tag']
						. $this->buildAttributes(isset($element['attributes']) ? $element['attributes'] : []) . '>';

				if (is_array($element['content'])) {
					foreach ($element['content'] as $part) {
						$html .= $this->elementBuilder($part);
					}
				} else {
					$html .= $element['content'];
				}

				$html .= '</' . $element['tag'] . '>';
			} else {
				$html .= $this->elementBuilder($element);
			}

		} else {
			$html .= $element;
		}

		return $html;
	}

	/**
	 *
	 * @return string
	 */
	protected function buildContent()
	{
		$html = '';

		if ($content = $this->element->content()) {
			$html = $this->elementBuilder($content);
		}

		return $html;
	}

	/**
	 * Build Html String
	 *
	 * @param ElementAbstract $element
	 * @return string
	 * @throws ElementException
	 */
	public function build(ElementAbstract $element)
	{
		$this->element = $element;

		// Check if tagName is set
		if (empty($tagName = $this->element->tagName())) {
			throw new ElementException('Failed to render HTML Element. Empty tagName');
		}

		// Start to build html string
		$html = '<' . $tagName;

		if (is_array($attributes = $this->element->attributes()) && count($attributes)) {
			$html .= ' ' . $this->buildAttributes($attributes);
		}

		$html .= '>';

		// Append content if exists
		if ($content = $this->buildContent()) {
			$html .= $content . "</{$this->element->tagName()}>";
		} else {
			$html .= '/>';
		}

		return $html;
	}
}