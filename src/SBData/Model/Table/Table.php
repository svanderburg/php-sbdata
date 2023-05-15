<?php
namespace SBData\Model\Table;
use SBData\Model\ReadOnlyForm;
use SBData\Model\Field\GenericHiddenField;
use SBData\Model\Field\HiddenNaturalNumberField;
use SBData\Model\Table\Iterator\TableIterator;

/**
 * A table that presents and validates collections of data. Each row is represented as a read-only form.
 */
class Table
{
	/** An associative array mapping field names to fields that should be checked and displayed */
	public array $columns;

	/** An associative array of labels mapping to function names displaying action links */
	public ?array $actions;

	/** Label to be displayed when there are no items in the table */
	public string $noItemsLabel;

	/** The prefix that the hidden anchor elements should have */
	public string $anchorPrefix;

	/** Indicates whether to add an extra column that can be used to track which row in the table is modified */
	public bool $identifyRows;

	/** Name of the identity column */
	public string $idColumnName;

	/** Iterator that steps over every row in the table and generates a form to be displayed */
	public TableIterator $iterator;

	/**
	 * Constructs a new Table instance.
	 *
	 * @param $columns An associative array mapping field names to fields that should be checked and displayed
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 * @param $noItemsLabel Label to be displayed when there are no items in the table
	 * @param $anchorPrefix The prefix that the hidden anchor elements should have
	 * @param $identifyRows Indicates whether to add an extra column that can be used to track which row in the table is modified
	 * @param $idColumnName Name of the identity column
	 */
	public function __construct(array $columns, array $actions = null, string $noItemsLabel = "No items", string $anchorPrefix = "table-row", bool $identifyRows = true, string $idColumnName = "__id")
	{
		$this->columns = $columns;
		$this->actions = $actions;
		$this->noItemsLabel = $noItemsLabel;
		$this->anchorPrefix = $anchorPrefix;
		$this->identifyRows = $identifyRows;
		$this->idColumnName = $idColumnName;

		if($identifyRows)
			$this->columns[$idColumnName] = new HiddenNaturalNumberField(false);
	}

	/**
	 * Clones the fields so that a form can be created out of it
	 *
	 * @return An array of cloned fields
	 */
	protected function cloneColumnFields(): array
	{
		$fields = array();

		foreach($this->columns as $id => $field)
			$fields[$id] = clone $field;

		return $fields;
	}

	/**
	 * Constructs a form out of the table's columns, which can be used to validate
	 * records that are inserted or modified in the table.
	 *
	 * @return A form with the table's columns as fields
	 */
	public function constructForm(): ReadOnlyForm
	{
		return new ReadOnlyForm($this->cloneColumnFields());
	}

	/**
	 * Computes the number of displayable columns.
	 *
	 * @return Number of displayable columns
	 */
	public function computeNumberOfDisplayableColumns(): int
	{
		$count = 0;

		foreach($this->columns as $id => $field)
		{
			if($field->visible)
				$count++;
		}

		return $count;
	}

	/**
	 * Configures an iterator that can be used to step over each row to be displayed in a table.
	 *
	 * @param $iterator Iterator to use
	 */
	public function setIterator(TableIterator $iterator): void
	{
		$this->iterator = $iterator;
		$this->iterator->identifyRows = $this->identifyRows;
		$this->iterator->idColumnName = $this->idColumnName;
		$this->iterator->setTable($this);
	}
}
