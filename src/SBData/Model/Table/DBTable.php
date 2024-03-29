<?php
namespace SBData\Model\Table;
use PDOStatement;
use SBData\Model\Form;
use SBData\Model\Label\Label;
use SBData\Model\Table\Iterator\DBTableIterator;

/**
 * A table that retrieves its data by executing a PDO Statement
 */
class DBTable extends Table
{
	/**
	 * Constructs a new DBTable instance.
	 *
	 * @param $columns An associative array mapping field names to fields that should be checked and displayed
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 * @param $noItemsLabel Label to be displayed when there are no items in the table
	 * @param $anchorPrefix The prefix that the hidden anchor elements should have
	 * @param $identifyRows Indicates whether to add an extra column that can be used to track which row in the table is modified
	 */
	public function __construct(array $columns, array $actions = null, string $noItemsLabel = "No items", string $anchorPrefix = "table-row", bool $identifyRows = true)
	{
		parent::__construct($columns, $actions, $noItemsLabel, $anchorPrefix, $identifyRows);
	}

	/**
	 * Attaches an executed PDOStatement object that fetches the data to be displayed from a RDBMS.
	 *
	 * @param $stmt PDO statement to attach
	 */
	public function setStatement(PDOStatement $stmt): void
	{
		$this->setIterator(new DBTableIterator($stmt));
	}
}
?>
