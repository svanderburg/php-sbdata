<?php
namespace SBData\Model\Table;
use SBData\Model\Form;
use SBData\Model\Label\Label;
use SBData\Model\Table\Iterator\ArrayTableIterator;

/**
 * A table that retrieves its data from an array of objects.
 */
class ArrayTable extends Table
{
	/**
	 * Constructs a new ArrayTable instace.
	 *
	 * @param $columns An associative array mapping field names to fields that should be checked and displayed
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 * @param $noItemsLabel Label to be displayed when there are no items in the table
	 * @param $anchorPrefix The prefix that the hidden anchor elements should have
	 * @param $identifyRows Indicates whether to add an extra column that can be used to track which row in the table is modified
	 */
	public function __construct(array $columns, ?array $actions = null, string $noItemsLabel = "No items", string $anchorPrefix = "table-row", bool $identifyRows = true)
	{
		parent::__construct($columns, $actions, $noItemsLabel, $anchorPrefix, $identifyRows);
	}

	/**
	 * Sets the table's data to an array containing associative arrays with the values for each column.
	 *
	 * @param $rows An array containing table data.
	 */
	public function setRows(array $rows): void
	{
		$this->setIterator(new ArrayTableIterator($rows));
	}
}
?>
