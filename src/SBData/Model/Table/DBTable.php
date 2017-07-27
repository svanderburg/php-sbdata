<?php
namespace SBData\Model\Table;

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
	 * @param array $actions An associative array of labels mapping to function names displaying action links
	 */
	public function __construct(array $columns, array $actions = null)
	{
		parent::__construct($columns, $actions);
	}
	
	/**
	 * @see Table::fetchForm()
	 */
	public function fetchForm()
	{
		if(($row = $this->stmt->fetch()) === false)
			return null;
		else
		{
			$form = $this->constructForm();
			$form->importValues($row);
			return $form;
		}
	}

	/**
	 * @see Table::computeNumberOfRows()
	 */
	public function computeNumberOfRows()
	{
		return $this->stmt->rowCount();
	}
}
?>
