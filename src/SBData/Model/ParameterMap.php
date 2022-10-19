<?php
namespace SBData\Model;

class ParameterMap
{
	public array $values;

	public function __construct(array $values)
	{
		$this->values = $values;
	}

	public function importValues(array $values)
	{
		foreach($this->values as $name => $value)
		{
			if(array_key_exists($name, $values))
				$value->value = $values[$name];
		}
	}

	public function exportValues(): array
	{
		$values = array();

		foreach($this->values as $key => $value)
			$values[$key] = $value->value;

		return $values;
	}

	public function checkValues(): bool
	{
		$status = true;

		foreach($this->values as $name => $field)
		{
			if(!$field->checkValue($name))
				$status = false;
		}

		return $status;
	}
}
?>
