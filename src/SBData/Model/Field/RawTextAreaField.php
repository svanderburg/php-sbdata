<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element containing arbitrary text
 * that should be displayed as a text area.
 */
class RawTextAreaField extends GenericTextAreaField
{
	/**
	 * Constructs a new RawTextAreaField instance
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $cols Amount of characters per row
	 * @param $rows Amount of rows in the text area
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(string $title, bool $mandatory = false, int $cols = 20, int $rows = 20, int $maxlength = null, $defaultValue = null)
	{
		parent::__construct($title, new Value($mandatory, $maxlength, $defaultValue), $cols, $rows);
	}
}
?>
