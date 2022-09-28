<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element that may be located
 * inside a form or a table.
 */
class Field
{
	/** Title of the field */
	public string $title;

	/** Indicates whether the given value is valid */
	public bool $valid;

	/** An object that stores and checks the value of the field */
	public Value $value;

	/** Namespace root where this field belongs to */
	public string $package = "SBData";

	/**
	 * Constructs a new Field instance.
	 *
	 * @param $title Title of the field
	 * @param $value An object that stores and checks the value of the field
	 */
	public function __construct(string $title, Value $value)
	{
		$this->title = $title;
		$this->value = $value;
		$this->valid = true;
	}

	/**
	 * Clones all relevant attributes of a field object.
	 */
	public function __clone()
	{
		$this->value = clone $this->value;
	}

	/**
	 * Imports a value into the field so that it can be checked or displayed.
	 *
	 * @param $value Value to import
	 */
	public function importValue($value): void
	{
		$this->value->value = $value;
	}

	/**
	 * Exports the stored value
	 *
	 * @return The stored value
	 */
	public function exportValue()
	{
		return $this->value->value;
	}

	/**
	 * Checks whether the field value is valid.
	 *
	 * @param $name Name of the field in the form or table
	 * @return true if the field's value is valid, else false
	 */
	public function checkField(string $name): bool
	{
		return $this->value->checkValue($name);
	}
}
