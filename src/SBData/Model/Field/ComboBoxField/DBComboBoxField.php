<?php
namespace SBData\Model\Field\ComboBoxField;
use Closure;
use PDO;
use PDOStatement;
use SBData\Model\Field\VisibleField;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element that should be displayed as a combo box
 * which data is retrieved from an RDBMS table.
 */
class DBComboBoxField extends VisibleField
{
	/** A database connection handler */
	public PDO $dbh;

	/** Function that fetches all possible options for the combobox */
	public string|Closure $queryOptionsFunction;

	/** Function that fetches the selected value for the combobox */
	public string|Closure $queryValueFunction;

	/**
	 * Constructs a new DBComboBoxField.
	 *
	 * @param $title Title of the field
	 * @param $dbh A database connection handler
	 * @param $queryOptionsFunction Function that fetches all possible options for the combobox
	 * @param $queryValueFunction Function that fetches the selected value for the combobox
	 * @param $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct(string $title, PDO $dbh, string|Closure $queryOptionsFunction, string|Closure $queryValueFunction, bool $mandatory = false)
	{
		parent::__construct($title, new Value($mandatory));
		$this->dbh = $dbh;
		$this->queryOptionsFunction = $queryOptionsFunction;
		$this->queryValueFunction = $queryValueFunction;
	}

	/**
	 * Iterates over all possible combobox options and returns an
	 * array containing option values for each iteration.
	 *
	 * @return array An associative array in which the key field points to the key and value to the value. It returns false if all options have been visited.
	 */
	public function fetchOption(PDOStatement $stmt): ?array
	{
		if(($row = $stmt->fetch()) === false)
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
	public function fetchValue(PDOStatement $stmt): ?string
	{
		if(($row = $stmt->fetch()) === false)
			return null;
		else
			return end($row);
	}
}
?>
