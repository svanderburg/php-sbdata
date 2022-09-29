<?php
namespace SBData\Model\Field\ComboBoxField;
use \PDOStatement;
use SBData\Model\Field\VisibleField;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element that should be displayed as a combo box
 * which data is retrieved from an RDBMS table.
 */
class DBComboBoxField extends VisibleField
{
	/** An executed PDOStatement in which the first resulting column is used for the keys and the second for the values */
	public PDOStatement $stmt;

	/**
	 * Constructs a new DBComboBoxField.
	 *
	 * @param $title Title of the field
	 * @param $stmt An executed PDOStatement in which the first resulting column is used for the keys and the second for the values
	 * @param $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct(string $title, PDOStatement $stmt, bool $mandatory = false)
	{
		parent::__construct($title, new Value($mandatory));
		$this->stmt = $stmt;
	}
	
	/**
	 * Iterates over all possible combobox options and returns an
	 * array containing option values for each iteration.
	 *
	 * @return array An associative array in which the key field points to the key and value to the value. It returns false if all options have been visited.
	 */
	public function fetchOption(): ?array
	{
		if(($row = $this->stmt->fetch()) === false)
			return null;
		else
		{
			if(count($row) == 1)
				return array(
					"key" => $row[0],
					"value" => $row[0]
				);
			else if(count($row) > 1)
				return array(
					"key" => $row[0],
					"value" => $row[1]
				);
		}
	}
	
	/**
	 * Fetches the value of the option that currently been selected.
	 *
	 * @return The actual value selected or false if an error has occured.
	 */
	public function fetchValue(): ?string
	{
		if(($row = $this->stmt->fetch()) === false)
			return null;
		else
			return $row[0];
	}
}
?>
