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
	public function __construct(string $title, bool $mandatory = false, int $size = 20, ?int $maxlength = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength);
	}
	
	/**
	 * @see TextField::checkField()
	 */
	public function checkField(string $name): bool
	{
		if(!parent::checkField($name))
			return false;

		if(!$this->mandatory && $this->value === "")
			return true;
		else
			return preg_match('/[0-9]+$/', $this->value) === 1;
	}
}
