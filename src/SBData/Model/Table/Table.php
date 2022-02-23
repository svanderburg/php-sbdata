<?php
namespace SBData\Model\Table;
use SBData\Model\Form;
use SBData\Model\Field\HiddenField;

/**
 * A table represents a collection of forms (with fields).
 */
abstract class Table
{
	/** An associative array of fields that should be checked and displayed */
	public array $columns;

	/** An associative array of labels mapping to function names displaying action links */
	public ?array $actions;

	/**
	 * Constructs a new Table instance.
	 *
	 * @param $columns An associative array of fields that should be checked and displayed
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 */
	public function __construct(array $columns, array $actions = null)
	{
		$this->columns = $columns;
		$this->actions = $actions;

		$this->columns["__id"] = new HiddenField(false); // Add __id column that is used to track which row in the table is modified
	}
	
	/**
	 * Constructs a form out of the table's columns, which can be used to validate
	 * records that are inserted or modified in the table.
	 *
	 * @return A form with the table's columns as fields
	 */
	public function constructForm(): Form
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
	 * @return A form instance representing a table row, or null if all table rows have been visited.
	 */
	public abstract function fetchForm(): Form|null;

	/**
	 * Returns the number of rows to be displayed.
	 *
	 * @return The number of rows
	 */
	public abstract function computeNumberOfRows(): int;

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
			if(!$field instanceof HiddenField && !$field instanceof MetaDataField)
				$count++;
		}

		return $count;
	}
}
