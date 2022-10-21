<?php
namespace SBData\Model\Table;
use PDO;
use SBData\Model\Pager;
use SBData\Model\ParameterMap;
use SBData\Model\Form;
use SBData\Model\Field\HiddenNumericIntField;

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
	 * @param $queryFunction Name of a function that determines the total amount of pages
	 * @param $parameterMap A map of values that correspond to page parameters
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 * @param $paramName Name of the parameter in the parameter map that indicates the page size (defaults to: page)
	 * @param $baseURL URL that user gets directed to (defaults to the same page)
	 * @param $identifyRows Indicates whether to add an extra column that can be used to track which row in the table is modified
	 */
	public function __construct(array $columns, PDO $dbh, int $pageSize, string $queryFunction, ParameterMap $parameterMap, array $actions = null, string $paramName = "page", string $baseURL = "", bool $identifyRows = true)
	{
		$columns[$paramName] = new HiddenNumericIntField(true);
		parent::__construct($columns, $actions, $parameterMap, $identifyRows);
		$this->pager = new Pager($dbh, $pageSize, $queryFunction, $parameterMap, $paramName, $baseURL);
	}

	/**
	 * @see Table::nextForm()
	 */
	public function nextForm(): Form|null
	{
		$form = parent::nextForm();

		if($form === null)
			return null;
		else
		{
			$page = $this->pager->determineCurrentPage();
			$form->fields[$this->pager->paramName]->importValue($page);
			return $form;
		}
	}
}
?>
