<?php
namespace SBData\Model;
use Closure;
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
	public string|Closure $queryFunction;

	/** Name of the parameter in the parameter map that indicates the page size */
	public string $paramName;

	/** URL that user gets directed to */
	public string $baseURL;

	/**
	 * Constructs a new pager instance.
	 *
	 * @param $dbh A database connection handler
	 * @param $pageSize Determines the page size
	 * @param $queryFunction Function that determines the total amount of pages
	 * @param $paramName Name of the parameter in the parameter map that indicates the page size (defaults to: page)
	 * @param $baseURL URL that user gets directed to (defaults to the same page)
	 */
	public function __construct(PDO $dbh, int $pageSize, string|Closure $queryFunction, string $paramName = "page", string $baseURL = "")
	{
		$this->dbh = $dbh;
		$this->pageSize = $pageSize;
		$this->queryFunction = $queryFunction;
		$this->paramName = $paramName;
		$this->baseURL = $baseURL;
	}

	/**
	 * Determines which page is currently selected.
	 *
	 * @param $requestParameters An array containing request parameters, e.g. $_GET/$_POST/$_REQUEST
	 * @return Current page number
	 */
	public function determineCurrentPage(array $requestParameters): int
	{
		if(array_key_exists($this->paramName, $requestParameters))
			return (int)($requestParameters[$this->paramName]);
		else
			return 0;
	}
}
?>
