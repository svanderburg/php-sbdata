<?php
namespace SBData\Model;

/**
 * A parameter map represents a collection of values that together represent one object.
 */
class ParameterMap
{
	/** An associative array mapping names to values that should be checked */
	public array $values;

	/**
	 * Constructs a new ParameterMap instance.
	 *
	 * @param $values An associative array mapping names to values that should be checked
	 */
	public function __construct(array $values)
	{
		$this->values = $values;
	}

	/**
	 * Imports an array of values into the form fields.
	 *
	 * @param $values An associative array in which every key corresponds to a field and every value to a field value.
	 */
	public function importValues(array $values)
	{
		foreach($this->values as $name => $value)
		{
			if(array_key_exists($name, $values))
				$value->value = $values[$name];
		}
	}

	/**
	 * Exports the values to an associative array having the same keys.
	 *
	 * @return An associative array with values
	 */
	public function exportValues(): array
	{
		$values = array();

		foreach($this->values as $key => $value)
			$values[$key] = $value->value;

		return $values;
	}

	/**
	 * Checks whether the values in the parameter map are valid.
	 */
	public function checkValues(): void
	{
		foreach($this->values as $name => $value)
			$value->valid = $value->checkValue($name);
	}

	/**
	 * Checks whether the parameter map (including all its values) are valid.
	 * This function should be called after ParameterMap::checkValues()
	 *
	 * @return true if and only if all values are valid
	 */
	public function checkValid(): bool
	{
		foreach($this->values as $name => $value)
		{
			if(!$value->valid)
				return false;
		}

		return true;
	}

	/**
	 * Composes an error message that explains which values are invalid.
	 *
	 * @param $prefix Error message prefix
	 * @return The prefix augmented with a comma separated list of invalid values
	 */
	public function composeErrorMessage(string $prefix): string
	{
		$message = $prefix;
		$first = true;

		foreach($this->values as $name => $value)
		{
			if(!$value->valid)
			{
				if($first)
				{
					$message .= " ".$name;
					$first = false;
				}
				else
					$message .= ", ".$name;
			}
		}

		return $message;
	}
}
?>
