<?php
require_once(dirname(__FILE__)."/../Form.class.php");
require_once(dirname(__FILE__)."/../field/HiddenField.class.php");

/**
 * A table represents a collection of forms (with fields).
 */
abstract class Table
{
	/** An associative array of fields that should be checked and displayed */
	public $columns;
	
	/**
	 * Constructs a new Table instance.
	 * 
	 * @param array $columns An associative array of fields that should be checked and displayed
	 */
	public function __construct(array $columns)
	{
		$this->columns = $columns;
		
		/* Add __id column that is used to track which row in the table is modified */
		$this->columns["__id"] = new HiddenField(true);
	}
	
	/**
	 * Constructs a form out of the table's columns, which can be used to validate
	 * records that are inserted or modified in the table.
	 * 
	 * @return Form A form with the table's columns as fields.
	 */
	public function constructForm()
	{
		/* Clone the columns fields */
		$fields = array();
		
		foreach($this->columns as $id => $field)
			$fields[$id] = clone $field;

		/* Construct a form with the fields */
		return new Form($fields);
	}
	
	/**
	 * Iterates over the collection of forms in the table and returns each one of them
	 * until the last one has been reached.
	 * 
	 * @return Form A form instance representing a table row, or null if all table rows have been visited.
	 */
	public abstract function fetchForm();
}
