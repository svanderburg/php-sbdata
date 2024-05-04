<?php
namespace SBData\Model\Value;

/**
 * Stores a generic value and checks if the basic essentials of user provided input are
 * right: whether a mandatory value is provided and whether it does not exceed
 * the maximum length if one is specified.
 */
class Value
{
	/** Stores the value of the field */
	public $value;

	/** Indicates whether the given value is valid */
	public bool $valid;

	/** Indicates whether a given value is mandatory */
	public bool $mandatory;

	/** Maximum size of the text field or null for infinite size */
	public ?int $maxlength;

	/** Stores the default value of the field */
	public $defaultValue;

	/**
	 * Constructs a new Value instance.
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(bool $mandatory = false, int $maxlength = null, $defaultValue = null)
	{
		$this->mandatory = $mandatory;
		$this->maxlength = $maxlength;
		$this->defaultValue = $defaultValue;
		$this->value = $defaultValue;
		$this->valid = true;
	}

	/**
	 * Clears the stored value.
	 */
	public function clearValue(): void
	{
		$this->value = $this->defaultValue;
	}

	/**
	 * Checks whether the value is correct.
	 *
	 * @param $name Name of the parameter in a form
	 * @return true if the value is correct, else false
	 */
	public function checkValue(string $name): bool
	{
		if($this->mandatory && $this->value == "") // Mandatory fields are not allowed to be empty
			return false;

		if($this->maxlength !== null && $this->value !== null && strlen($this->value) > $this->maxlength) // Text fields cannot exceed their maximum length
			return false;

		return true;
	}
}
?>
