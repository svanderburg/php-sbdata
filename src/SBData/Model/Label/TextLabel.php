<?php
namespace SBData\Model\Label;

/**
 * Encodes a label that only displays text
 */
class TextLabel extends Label
{
	/** Text to display */
	public string $text;

	/**
	 * Constructs a new text label instance.
	 *
	 * @param $text Text to display
	 */
	public function __construct(string $text)
	{
		$this->text = $text;
	}
}
?>
