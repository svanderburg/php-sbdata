<?php
require_once(dirname(__FILE__)."/../TextField.class.php");

/**
 * Represents the structure of an individual data element that should be displayed as a combo box
 * which data is retrieved from an RDBMS table.
 */
class DBComboBoxField extends TextField
{
	/** An executed PDOStatement in which the first resulting column is used for the keys and the second for the values */
	public $stmt;
	
	/**
	 * Constructs a new DBComboBoxField.
	 * 
	 * @param string $title Title of the field
	 * @param PDOStatement $stmt An executed PDOStatement in which the first resulting column is used for the keys and the second for the values
	 * @param bool $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct($title, $stmt, $mandatory = false)
	{
		parent::__construct($title, $mandatory);
		$this->stmt = $stmt;
	}
	
	/**
	 * Iterates over all possible combobox options and returns an
	 * array containing option values for each iteration.
	 * 
	 * @return array An associative array in which the key field points to the key and value to the value. It returns null if all options have been visited.
	 */
	public function fetchOption()
	{
		if($row = $this->stmt->fetch())
		{
			if(count($row) == 1)
				return array(
					"key" => $row[0],
					"value" => $row[0]
				);
			else if(count($row) > 1)
				return array(
					"key" => $row[0],
					"value" => $row[1]
				);
		}
		else
			return null;
	}
	
	/**
	 * Fetches the value of the option that currently been selected.
	 * 
	 * @return string The actual value selected or null if an error has occured.
	 */
	public function fetchValue()
	{
		if($row = $this->stmt->fetch())
			return $row[0];
		else
			return null;
	}
}
?>
