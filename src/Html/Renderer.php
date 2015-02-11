<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 11.02.15.
 * Time: 14:30
 */
namespace Djob\Bridge\Html;

class Renderer
{
	protected $element;

	public function __construct(ElementAbstract $element)
	{
		$this->element = $element;
	}

	protected function renderAttributes()
	{
		$html = '';

		// Check for attributes
		if (is_array($attributes = $this->element->attributes())) {
			foreach ($attributes as $attributeName => $attributeValue) {
				$html .= " {$attributeName}=\"{$attributeValue}\"";
			}
		}

		return $html;
	}

	protected function renderContent()
	{
		$html = '';

		if ($content = $this->element->content()) {
			foreach ($content as $cnt) {
				$html .= $cnt;
			}
		}

		return $html;
	}

	public function render()
	{
		// Check if tagName is set
		if (empty($tagName = $this->element->tagName())) {
			throw new ElementException('Failed to render HTML Element. Empty tagName');
		}

		// Start to build html string
		$html = '<' . $tagName;
		$html .= $this->renderAttributes();
		$html .= '>';

		// Append content if exists
		if ($content = $this->renderContent()) {
			$html .= $content;
			$html .= "</>";
		} else {
			$html .= '/>';
		}

		return $html;
	}
}