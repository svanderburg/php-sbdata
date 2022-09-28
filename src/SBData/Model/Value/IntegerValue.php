<?php
namespace SBData\Model\Value;

/**
 * Stores a value and checks whether it is a valid integer number.
 */
class IntegerValue extends SaneStringValue
{
	/**
	 * @see Value::checkValue()
	 */
	public function checkValue(string $name): bool
	{
		if(!parent::checkValue($name))
			return false;

		if($this->value === "")
			return true;
		else
			return preg_match('/[0-9]+$/', $this->value) === 1;
	}
}
?>
