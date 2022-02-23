<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containing linking to another page.
 */
class KeyLinkField extends TextField
{
	/** Name of the function that composes the URL where the field should be linked to */
	public string $composeURLFunction;

	/**
	 * Constructs a new KeyLinkField instance
	 *
	 * @param $title Title of the field
	 * @param $composeURLFunction Name of the function that composes the URL where the field should be linked to
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $size Preferred size of the text field
	 * @param $maxlength Maximum size of the text field or null for infinity size
	 */
	public function __construct(string $title, string $composeURLFunction, bool $mandatory = false, int $size = 20, ?int $maxlength = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength);
		$this->composeURLFunction = $composeURLFunction;
	}
}
?>
