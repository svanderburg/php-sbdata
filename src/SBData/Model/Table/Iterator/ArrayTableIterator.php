<?php
namespace SBData\Model\Table\Iterator;
use ArrayIterator;

/**
 * An iterator that steps over each form that needs to be displayed as a row in a table using an array as a data source.
 */
class ArrayTableIterator extends TableIterator
{
	private ArrayIterator $arrayIterator;

	/**
	 * Creates a new ArrayTableIterator instance.
	 *
	 * @param $array Array that is used as a data source
	 */
	public function __construct(array $array)
	{
		$this->arrayIterator = new ArrayIterator($array);
	}

	public function current(): mixed
	{
		return $this->constructForm($this->arrayIterator->current());
	}

	public function key(): mixed
	{
		return $this->arrayIterator->key();
	}

	public function next(): void
	{
		$this->arrayIterator->next();
	}

	public function rewind(): void
	{
		$this->arrayIterator->rewind();
	}

	public function valid(): bool
	{
		return $this->arrayIterator->valid();
	}
}
?>
