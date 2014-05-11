<?php
require_once("Table.class.php");
require_once(dirname(__FILE__)."/../Form.class.php");

/**
 * A table that retrieves its data by executing a PDO Statement
 */
class DBTable extends Table
{
	/** An executed PDOStatement object that fetches the data to be displayed from a RDBMS */ 
	public $stmt;
	
	/**
	 * Constructs a new DBTable instance.
	 * 
	 * @param array $columns An executed PDOStatement object that fetches the data to be displayed from a RDBMS
	 */
	public function __construct(array $columns)
	{
		parent::__construct($columns);
	}
	
	/**
	 * @see Table::fetchForm()
	 */
	public function fetchForm()
	{
		if($row = $this->stmt->fetch())
		{
			$form = $this->constructForm();
			$form->importValues($row);
			return $form;
		}
		else
			return null;
	}
}
?>
