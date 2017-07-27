<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containing linking to another page.
 */
class KeyLinkField extends TextField
{
	/* Name of the function that composes the URL where the field should be linked to */
	public $composeURLFunction;

	/**
	 * Constructs a new KeyLinkField instance
	 *
	 * @param string $title Title of the field
	 * @param string $composeURLFunction Name of the function that composes the URL where the field should be linked to
	 * @param bool $mandatory Indicates whether a given value is mandatory
	 * @param int $size Preferred size of the text field
	 * @param int $maxlength Maximum size of the text field or null for infinity size
	 */
	public function __construct($title, $composeURLFunction, $mandatory = false, $size = 20, $maxlength = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength);
		$this->composeURLFunction = $composeURLFunction;
	}
}
?>
