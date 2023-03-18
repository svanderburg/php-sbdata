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
	 * @param $columns An associative array mapping field names to fields that should be checked and displayed
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 * @param $noItemsLabel Label to be displayed when there are no items in the table
	 * @param $anchorPrefix The prefix that the hidden anchor elements should have
	 * @param $editLabel Label to be displayed on the edit button
	 * @param $actionURL Action URL where the user gets redirected to (defaults to same page)
	 * @param $identifyRows Indicates whether to add an extra column that can be used to track which row in the table is modified
	 */
	public function __construct(array $columns, array $actions = null, string $noItemsLabel = "No items", string $anchorPrefix = "table-row", string $editLabel = "Edit", string $actionURL = null, bool $identifyRows = true)
	{
		parent::__construct($columns, $actions, $noItemsLabel, $anchorPrefix, $editLabel, $actionURL, $identifyRows);
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
