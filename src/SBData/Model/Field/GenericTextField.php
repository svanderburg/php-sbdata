<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of a data element that should be presented as a text
 * field.
 */
class GenericTextField extends Field
{
	/** Preferred size of the text field */
	public int $size;

	/**
	 * Constructs a new GenericTextField instance
	 *
	 * @param $title Title of the field
	 * @param $value An object that stores and checks the value of the field
	 * @param $size Preferred size of the text field
	 */
	public function __construct(string $title, Value $value, int $size = 20)
	{
		parent::__construct($title, $value);
		$this->size = $size;
	}
}
?>
