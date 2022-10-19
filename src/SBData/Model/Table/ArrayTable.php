<?php
namespace SBData\Model\Table;
use SBData\Model\ParameterMap;
use SBData\Model\Form;

/**
 * A table that retrieves its data from an array of objects.
 */
class ArrayTable extends Table
{
	/** An array containing table data */
	public array $rows;
	
	/**
	 * Constructs a new ArrayTable instace.
	 *
	 * @param $columns An associative array of fields that should be checked and displayed
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 * @param $parameterMap A map of parameters that can be consumed by any form consumer
	 * @param $identifyRows Indicates whether to add an extra column that can be used to track which row in the table is modified
	 */
	public function __construct(array $columns, array $actions = null, ParameterMap $parameterMap = null, bool $identifyRows = true)
	{
		parent::__construct($columns, $actions, $parameterMap, $identifyRows);
	}
	
	/**
	 * Sets the table's data to an array containing associative arrays with the values for each column.
	 *
	 * @param $rows An array containing table data.
	 */
	public function setRows(array $rows): void
	{
		$this->rows = $rows;
		reset($this->rows);
	}
	
	/**
	 * @see Table::fetchForm()
	 */
	public function fetchForm(): Form|null
	{
		$row = current($this->rows);
		
		if($row)
		{
			$form = $this->constructForm();
			$form->importValues($row);
			next($this->rows);
			return $form;
		}
		else
			return null;
	}
}
?>
