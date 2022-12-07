<?php
namespace SBData\Model\Table;
use SBData\Model\Form;
use SBData\Model\Field\GenericHiddenField;
use SBData\Model\Field\HiddenNumericIntField;

/**
 * A table represents a collection of forms (with fields).
 */
abstract class Table
{
	/** An associative array mapping field names to fields that should be checked and displayed */
	public array $columns;

	/** An associative array of labels mapping to function names displaying action links */
	public ?array $actions;

	/** Action URL where the user gets redirected to (defaults to same page) */
	public ?string $actionURL;

	/** Indicates whether to add an extra column that can be used to track which row in the table is modified */
	public bool $identifyRows;

	/** Counts the amount of retrieved rows */
	public int $rowCount;

	/**
	 * Constructs a new Table instance.
	 *
	 * @param $columns An associative array mapping field names to fields that should be checked and displayed
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 * @param $actionURL Action URL where the user gets redirected to (defaults to same page)
	 * @param $identifyRows Indicates whether to add an extra column that can be used to track which row in the table is modified
	 */
	public function __construct(array $columns, array $actions = null, string $actionURL = "", bool $identifyRows = true)
	{
		$this->columns = $columns;
		$this->actions = $actions;
		$this->actionURL = $actionURL;
		$this->identifyRows = $identifyRows;
		$this->rowCount = 0;

		if($identifyRows)
			$this->columns["__id"] = new HiddenNumericIntField(false);
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
		return new Form($fields, $this->actionURL);
	}
	
	/**
	 * Iterates over the data in the table and returns a form instance for
	 * each row until the last one has been reached.
	 *
	 * @return A form instance representing a table row, or null if all table rows have been visited.
	 */
	public abstract function fetchForm(): Form|null;

	/**
	 * Iterates over the data in the table, modifies it if needed, and
	 * returns a form instance for each row until the last one has been
	 * reached.
	 *
	 * @return A form instance representing a table row, or null if all table rows have been visited.
	 */
	public function nextForm(): Form|null
	{
		$form = $this->fetchForm();

		if($form === null)
			return null;
		else
		{
			if($this->identifyRows)
				$form->fields["__id"]->importValue($this->rowCount);

			$this->rowCount++;
			return $form;
		}
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
}
