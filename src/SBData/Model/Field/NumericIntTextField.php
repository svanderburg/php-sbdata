<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containing only numeric values.
 */
class NumericIntTextField extends TextField
{
	/**
	 * @see TextField::__construct()
	 */
	public function __construct($title, $mandatory = false, $size = 20, $maxlength = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength);
	}
	
	/**
	 * @see TextField::checkField()
	 */
	public function checkField($name)
	{
		if(!parent::checkField($name))
			return false;

		if(!$this->mandatory && $this->value === "")
			return true;
		else
			return preg_match('/[0-9]+$/', $this->value);
	}
}
