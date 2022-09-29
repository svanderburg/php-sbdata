<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element containing a link to another page.
 */
class KeyLinkField extends VisibleField
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
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 */
	public function __construct(string $title, string $composeURLFunction, bool $mandatory = false, int $size = 20, ?int $maxlength = null)
	{
		parent::__construct($title, new Value($mandatory, $maxlength));
		$this->composeURLFunction = $composeURLFunction;
	}
}
?>
