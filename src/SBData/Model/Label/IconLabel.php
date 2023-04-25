<?php
namespace SBData\Model\Label;

/**
 * Encodes a label that displays an icon (with alternate text)
 */
class IconLabel extends TextLabel
{
	/** Icon to display */
	public string $icon;

	/**
	 * Constructs a new text label instance.
	 *
	 * @param $text Text to display
	 * @param $icon Icon to display
	 */
	public function __construct(string $text, string $icon)
	{
		parent::__construct($text);
		$this->icon = $icon;
	}
}
?>
