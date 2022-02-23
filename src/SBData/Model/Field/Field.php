<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element that may be located
 * inside a form or a table.
 */
abstract class Field
{
	/** Title of the field */
	public string $title;
	
	/** Indicates whether a given value is mandatory */
	public bool $mandatory;
	
	/** Indicates whether the given value is valid */
	public bool $valid;
	
	/** Stores the value of the field */
	public $value;
	
	/** Namespace root where this field belongs to */
	public string $package = "SBData";
	
	/**
	 * Constructs a new Field instance
	 * 
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct(string $title, bool $mandatory = false)
	{
		$this->title = $title;
		$this->mandatory = $mandatory;
		$this->valid = true;
		$this->value = null;
	}
	
	/**
	 * Checks whether the field value is valid.
	 *
	 * @param $name Name of the field in the form or table
	 * @return true if the field's value is valid, else false
	 */
	public abstract function checkField(string $name): bool;
}
