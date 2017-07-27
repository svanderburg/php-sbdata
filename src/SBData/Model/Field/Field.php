<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element that may be located
 * inside a form or a table.
 */
abstract class Field
{
	/** Title of the field */
	public $title;
	
	/** Indicates whether a given value is mandatory */
	public $mandatory;
	
	/** Indicates whether the given value is valid */
	public $valid;
	
	/** Stores the value of the field */
	public $value;
	
	/**
	 * Constructs a new Field instance
	 * 
	 * @param string $title Title of the field
	 * @param bool $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct($title, $mandatory = false)
	{
		$this->title = $title;
		$this->mandatory = $mandatory;
		$this->valid = true;
		$this->value = null;
	}
	
	/**
	 * Checks whether the field value is valid.
	 * 
	 * @param string $name Name of the field in the form or table
	 */
	public abstract function checkField($name);
}
