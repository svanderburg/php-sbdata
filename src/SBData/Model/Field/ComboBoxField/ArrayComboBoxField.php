<?php
namespace SBData\Model\Field\ComboBoxField;
use SBData\Model\Field\VisibleField;
use SBData\Model\Value\StringArrayElementValue;

/**
 * Represents the structure of an individual data element that should be displayed as a combo box
 * which data is retrieved from an array of objects.
 */
class ArrayComboBoxField extends VisibleField
{
	/**
	 * Constructs a new ArrayComboBoxField instance.
	 *
	 * @param $title Title of the field
	 * @param $values An array in which the keys correspond to the input names and values to their descriptions
	 * @param $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct(string $title, array $values, bool $mandatory = false)
	{
		parent::__construct($title, new StringArrayElementValue($values, $mandatory));
	}
}
?>
