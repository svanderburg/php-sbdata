<?php
namespace SBData\Model\Value;

/**
 * Stores a value and checks whether it is a valid ISO date: YYYY-MM-DD
 */
class ISODateValue extends Value
{
	/**
	 * Constructs a new ISODateValue instance.
	 *
	 * @param $defaultToCurrentDate Indicates whether the default value should be set to today
	 * @param $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct(bool $defaultToCurrentDate = false, bool $mandatory = false)
	{
		parent::__construct($mandatory, 10);

		if($defaultToCurrentDate)
			$this->value = date("Y-m-d");
	}

	/**
	 * @see Value::checkValue()
	 */
	function checkValue(string $name): bool
	{
		if(!parent::checkValue($name))
			return false;

		if($this->value === "")
			return true;
		else if(preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $this->value) === 1)
			return checkdate(substr($this->value, 5, 2), substr($this->value, 8, 2), substr($this->value, 0, 4));
		else
			return false;
	}
}
?>
