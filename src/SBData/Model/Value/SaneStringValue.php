<?php
namespace SBData\Model\Value;

/**
 * Stores a value and ensures that it is sane (free from trailing white spaces).
 */
class SaneStringValue extends Value
{
	/**
	 * @see Value::checkValue()
	 */
	public function checkValue(string $name): bool
	{
		if($this->value !== null)
			$this->value = trim($this->value); // Trim whitespace that comes in front and after the input

		return parent::checkValue($name);
	}
}
?>
