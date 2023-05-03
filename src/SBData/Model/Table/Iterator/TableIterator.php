<?php
namespace SBData\Model\Table\Iterator;
use Iterator;
use SBData\Model\Form;
use SBData\Model\Table\Table;

/**
 * An iterator that steps over each form that needs to be displayed as a row in a table.
 */
abstract class TableIterator implements Iterator
{
	/** Table where the iterator belongs to */
	private Table $table;

	/** Indicates whether to add an extra column that can be used to track which row in the table is modified */
	public bool $identifyRows = false;

	/** Name of the identity column */
	public string $idColumnName = "__id";

	/** Maintains a row counter */
	private int $rowCount = 0;

	/**
	 * Sets the table where the iterator belongs to
	 *
	 * @param $table Table where the iterator belongs to
	 */
	public function setTable(Table $table): void
	{
		$this->table = $table;
	}

	/**
	 * Constructs a form that can be used to display and check a row.
	 *
	 * @param $row An object containing the data fields
	 * @return A form that can be used to display and check the data in a row
	 */
	public function constructForm(array $row): Form
	{
		$form = $this->table->constructForm();
		$form->importValues($row);

		if($this->identifyRows)
			$form->fields[$this->idColumnName]->importValue($this->rowCount);

		$this->rowCount++;

		return $form;
	}

	/**
	 * @see Iterator#current()
	 */
	public abstract function current(): mixed;

	/**
	 * @see Iterator#key()
	 */
	public abstract function key(): mixed;

	/**
	 * @see Iterator#next()
	 */
	public abstract function next(): void;

	/**
	 * @see Iterator#rewind()
	 */
	public abstract function rewind(): void;

	/**
	 * @see Iterator#valid()
	 */
	public abstract function valid(): bool;
}
?>
