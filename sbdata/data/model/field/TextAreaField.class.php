<?php
require_once("TextField.class.php");

/**
 * Represents the structure of an individual data element containing arbitrary text
 * that should be displayed as a text area.
 */
class TextAreaField extends TextField
{
	/** Amount of characters per row */
	public $cols;
	
	/** Amount of rows in the text area */
	public $rows;
	
	/**
	 * Constructs a new TextAreaField instance
  	 *
	 * @param string $title Title of the field
	 * @param bool $mandatory Indicates whether a given value is mandatory
	 * @param int $cols Amount of characters per row
	 * @param int $rows Amount of rows in the text area
	 */
	public function __construct($title, $mandatory = false, $cols = 20, $rows = 20)
	{
		parent::__construct($title, $mandatory);
		$this->cols = $cols;
		$this->rows = $rows;
	}
}
?>
