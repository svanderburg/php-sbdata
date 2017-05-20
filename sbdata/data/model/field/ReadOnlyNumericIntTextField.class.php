<?php
require_once("NumericIntTextField.class.php");

/**
 * Represents the structure of an individual data element that can be displayed
 * as text, but cannot be edited
 */
class ReadOnlyNumericIntTextField extends NumericIntTextField
{
	/**
	 * @see TextField::__construct()
	 */
	public function __construct($title, $mandatory, $size = 20, $maxlength = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength);
	}
	
	/**
	 * @see TextField::checkField()
	 */
	public function checkField($name)
	{
		return parent::checkField($name);
	}
}
