<?php
namespace SBData\Model\Value;

/**
 * Stores a value and checks whether it is a valid URL.
 */
class URLValue extends SaneStringValue
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
			return (filter_var($this->value, FILTER_VALIDATE_URL) !== false);
	}
}
?>
