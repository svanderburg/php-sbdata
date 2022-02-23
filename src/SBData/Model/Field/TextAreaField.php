<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containing arbitrary text
 * that should be displayed as a text area.
 */
class TextAreaField extends TextField
{
	/** Amount of characters per row */
	public int $cols;
	
	/** Amount of rows in the text area */
	public int $rows;
	
	/**
	 * Constructs a new TextAreaField instance
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $cols Amount of characters per row
	 * @param $rows Amount of rows in the text area
	 */
	public function __construct(string $title, bool $mandatory = false, int $cols = 20, int $rows = 20)
	{
		parent::__construct($title, $mandatory);
		$this->cols = $cols;
		$this->rows = $rows;
	}
}
?>
