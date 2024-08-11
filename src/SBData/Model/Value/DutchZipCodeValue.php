<?php
namespace SBData\Model\Value;

/**
 * Stores a value and checks whether it is a valid Dutch zip code consisting of 4 digits followed by two alphabetic characters
 */
class DutchZipCodeValue extends Value
{
	/**
	 * Constructs a new DutchZipCodeValue instance.
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(bool $mandatory = false, $defaultValue = null)
	{
		parent::__construct($mandatory, 6, $defaultValue);
	}

	/**
	 * @see Value::checkValue()
	 */
	function checkValue(string $name): bool
	{
		if(!parent::checkValue($name))
			return false;

		return ($this->value === "" || preg_match("/^[0-9]{4}[a-zA-Z]{2}$/", $this->value) === 1);
	}
}
?>
