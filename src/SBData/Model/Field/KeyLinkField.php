<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 *
 * Represents the structure of an individual data element representing a string that can be used to
 * compose a link to another page.
 */
class KeyLinkField extends GenericKeyLinkField
{
	/**
	 * Constructs a new KeyLinkField instance
	 *
	 * @param $title Title of the field
	 * @param $composeURLFunction Name of the function that composes the URL where the field should be linked to
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(string $title, string $composeURLFunction, bool $mandatory = false, int $maxlength = null, $defaultValue = null)
	{
		parent::__construct($title, $composeURLFunction, new Value($mandatory, $maxlength, $defaultValue));
	}
}
?>
