<?php
namespace SBData\Model\Value;

/**
 * Stores a value and checks whether it is a valid integer number.
 */
class IntegerValue extends SaneStringValue
{
	/** Specifies the minimum value that is allowed or null if there is no lower boundary */
	public ?int $minValue;

	/** Specifies the maximum value that is allowed or null if there is no upper boundary */
	public ?int $maxValue;

	/**
	 * Constructs a new Value instance.
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 * @param $minValue Specifies the minimum value that is allowed or null if there is no lower boundary (defaults to null)
	 * @param $maxValue Specifies the maximum value that is allowed or null if there is no upper boundary (defaults to null)
	 */
	public function __construct(bool $mandatory = false, int $maxlength = null, $defaultValue = null, int $minValue = null, int $maxValue = null)
	{
		parent::__construct($mandatory, $maxlength, $defaultValue);
		$this->minValue = $minValue;
		$this->maxValue = $maxValue;
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

		if($this->value !== null && preg_match('/[0-9]+$/', $this->value) !== 1)
			return false;

		if($this->minValue !== null && $this->value < $this->minValue)
			return false;

		if($this->maxValue !== null && $this->value > $this->maxValue)
			return false;

		return true;
	}
}
?>
