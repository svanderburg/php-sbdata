<?php
namespace SBData\Model;
use PDO;

/**
 * Captures the properties of a page that navigates a user through a data
 * collection that is divided into pages of a fixed size.
 */
class Pager
{
	/** A database connection handler */
	public PDO $dbh;

	/** Determines the page size */
	public int $pageSize;

	/** Name of a function that determines the total amount of pages */
	public string $queryFunction;

	/** A map of values that correspond to page parameters */
	public ParameterMap $parameterMap;

	/** Name of the parameter in the parameter map that indicates the page size */
	public string $paramName;

	/** URL that user gets directed to */
	public string $baseURL;

	/**
	 * Constructs a new pager instance.
	 *
	 * @param $dbh A database connection handler
	 * @param $pageSize Determines the page size
	 * @param $queryFunction Name of a function that determines the total amount of pages
	 * @param $parameterMap A map of values that correspond to page parameters
	 * @param $paramName Name of the parameter in the parameter map that indicates the page size (defaults to: page)
	 * @param $baseURL URL that user gets directed to (defaults to the same page)
	 */
	public function __construct(PDO $dbh, int $pageSize, string $queryFunction, ParameterMap $parameterMap, string $paramName = "page", string $baseURL = "")
	{
		$this->dbh = $dbh;
		$this->pageSize = $pageSize;
		$this->queryFunction = $queryFunction;
		$this->paramName = $paramName;
		$this->baseURL = $baseURL;
		$this->parameterMap = $parameterMap;
	}

	/**
	 * Determines which page is currently selected.
	 *
	 * @return Current page number
	 */
	public function determineCurrentPage(): int
	{
		if(array_key_exists($this->paramName, $this->parameterMap->values))
			return (int)($this->parameterMap->values[$this->paramName]->value);
		else
			return 0;
	}
}
?>
