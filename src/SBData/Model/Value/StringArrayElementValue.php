<?php
namespace SBData\Model\Value;

/**
 * Stores a value and checks whether it is in an array of possible outcomes.
 */
class StringArrayElementValue extends Value
{
	/** An array in which the keys correspond to the input names and values to their descriptions */
	public array $values;

	/**
	 * Creates a new StringArrayElementValue instance.
	 *
	 * @param $values An array in which the keys correspond to the input names and values to their descriptions
	 * @param $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct(array $values, bool $mandatory = false)
	{
		parent::__construct($mandatory);
		$this->values = $values;
	}

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
			return array_key_exists($this->value, $this->values);
	}
}
?>
