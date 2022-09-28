<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element containing text
 * that should be displayed as a text area.
 */
class GenericTextAreaField extends Field
{
	/** Amount of characters per row */
	public int $cols;

	/** Amount of rows in the text area */
	public int $rows;

	/**
	 * Constructs a new TextAreaField instance
	 *
	 * @param $title Title of the field
	 * @param $value An object that stores and checks the value of the field
	 * @param $cols Amount of characters per row
	 * @param $rows Amount of rows in the text area
	 */
	public function __construct(string $title, Value $value, int $cols = 20, int $rows = 20)
	{
		parent::__construct($title, $value);
		$this->cols = $cols;
		$this->rows = $rows;
	}
}
?>
