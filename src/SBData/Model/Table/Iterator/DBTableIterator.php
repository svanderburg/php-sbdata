<?php
namespace SBData\Model\Table\Iterator;
use PDOStatement;

/**
 * An iterator that steps over each form that needs to be displayed as a row in a table using an execute database statement as a data source.
 */
class DBTableIterator extends TableIterator
{
	private $row;

	private PDOStatement $stmt;

	/**
	 * Creates a new DBTableIterator instance.
	 *
	 * @param $stmt A PDOStatement that is used as a data source
	 */
	public function __construct(PDOStatement $stmt)
	{
		$this->stmt = $stmt;
	}

	public function current(): mixed
	{
		return $this->constructForm($this->row);
	}

	public function key(): mixed
	{
		return null;
	}

	public function next(): void
	{
		$this->row = $this->stmt->fetch();
	}

	public function rewind(): void
	{
		$this->row = $this->stmt->fetch();
	}

	public function valid(): bool
	{
		return ($this->row !== false);
	}
}
?>
