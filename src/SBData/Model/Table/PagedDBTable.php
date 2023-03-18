<?php
namespace SBData\Model\Table;
use Closure;
use PDO;
use SBData\Model\Pager;
use SBData\Model\Form;

/**
 * A table that retrieves its data by executing a PDO Statement and handles data
 * that is divided into pages of a fixed size.
 */
class PagedDBTable extends DBTable
{
	/** Object that manages the navigation through pages */
	public Pager $pager;

	/**
	 * Constructs a new PagedDBTable instance.
	 *
	 * @param $columns An executed PDOStatement object that fetches the data to be displayed from a RDBMS
	 * @param $dbh A database connection handler
	 * @param $pageSize Determines the page size
	 * @param $queryFunction Function that determines the total amount of pages
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 * @param $actionURL Action URL where the user gets redirected to (defaults to same page)
	 * @param $noItemsLabel Label to be displayed when there are no items in the table
	 * @param $anchorPrefix The prefix that the hidden anchor elements should have
	 * @param $editLabel Label to be displayed on the edit button
	 * @param $baseURL URL that the user gets directed when paging (defaults to the same page)
	 * @param $paramName Name of the parameter in the parameter map that indicates the page size (defaults to: page)
	 * @param $identifyRows Indicates whether to add an extra column that can be used to track which row in the table is modified
	 */
	public function __construct(array $columns, PDO $dbh, int $pageSize, string|Closure $queryFunction, array $actions = null, string $actionURL = "", string $noItemsLabel = "No items", string $anchorPrefix = "table-row", string $editLabel = "Edit", string $baseURL = "", string $paramName = "page", bool $identifyRows = true)
	{
		parent::__construct($columns, $actions, $noItemsLabel, $anchorPrefix, $editLabel, $actionURL, $identifyRows);
		$this->pager = new Pager($dbh, $pageSize, $queryFunction, $paramName, $baseURL);
	}
}
?>
