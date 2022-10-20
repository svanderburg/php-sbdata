<?php
namespace SBData\Model\Field;
use SBData\Model\Value\URLValue;

/**
* Represents the structure of an individual data element containing an URL.
*/
class URLField extends GenericTextField
{
	/**
	 * Constructs a new URLField instance.
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $size Preferred size of the text field
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(string $title, bool $mandatory = false, int $size = 20, int $maxlength = null, $defaultValue = null)
	{
		parent::__construct($title, new URLValue($mandatory, $maxlength, $defaultValue), $size);
	}
}
?>
