<?php
namespace SBData\Model\Table;
use PDOStatement;
use SBData\Model\Form;

/**
 * A table that retrieves its data by executing a PDO Statement
 */
class DBTable extends Table
{
	/** An executed PDOStatement object that fetches the data to be displayed from a RDBMS */
	public PDOStatement $stmt;

	/**
	 * Constructs a new DBTable instance.
	 *
	 * @param $columns An executed PDOStatement object that fetches the data to be displayed from a RDBMS
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 * @param $actionURL Action URL where the user gets redirected to (defaults to same page)
	 * @param $identifyRows Indicates whether to add an extra column that can be used to track which row in the table is modified
	 */
	public function __construct(array $columns, array $actions = null, string $actionURL = null, bool $identifyRows = true)
	{
		parent::__construct($columns, $actions, $actionURL, $identifyRows);
	}
	
	/**
	 * @see Table::fetchForm()
	 */
	public function fetchForm(): Form|null
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
}
?>
