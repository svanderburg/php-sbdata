<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");
require_once("includes/db.php");

use SBData\Model\ParameterMap;
use SBData\Model\Value\IntegerValue;
use SBData\Model\Value\PageValue;
use SBData\Model\Form;
use SBData\Model\Table\PagedDBTable;
use SBData\Model\Field\ReadOnlyNumericIntTextField;
use SBData\Model\Field\TextField;
use SBData\Model\Table\Anchor\AnchorRow;
use Examples\TodoList\Entity\TodoItem;

$pageSize = 5;

function importAndCheckParameters(): array
{
	$requestMap = new ParameterMap(array(
		"viewmode" => new IntegerValue(false),
		"ITEM_ID" => new IntegerValue(false, 255),
		"page" => new PageValue()
	));

	$requestMap->importValues($_REQUEST);
	$requestMap->checkValues();

	if($requestMap->checkValid())
		return $requestMap->exportValues();
	else
		throw new Exception($requestMap->composeErrorMessage("The following parameters are invalid:"));
}

function constructTable(PDO $dbh, int $pageSize, array $requestParameters): PagedDBTable
{
	$queryNumOfPagesFunction = function (PDO $dbh, int $pageSize): int
	{
		return ceil(TodoItem::queryNumOfItems($dbh) / $pageSize);
	};

	$deleteTodoItemLinkFunction = function (Form $form) use ($requestParameters): string
	{
		return "?".http_build_query(array(
			"__operation" => "delete",
			"ITEM_ID" => $form->fields["ITEM_ID"]->exportValue(),
			"page" => $requestParameters["page"]
		), "", "&amp;", PHP_QUERY_RFC3986);
	};

	$actionURL = $_SERVER["PHP_SELF"]."?".http_build_query(array(
		"page" => $requestParameters["page"]
	), "", "&amp;", PHP_QUERY_RFC3986);

	return new PagedDBTable(array(
		"ITEM_ID" => new ReadOnlyNumericIntTextField("Id", true, 20, 255),
		"Description" => new TextField("Description", true, 30, 255)
	), $dbh, $pageSize, $queryNumOfPagesFunction, array(
		"Delete" => $deleteTodoItemLinkFunction
	), $actionURL);
}

function executeOperation(PagedDBTable $table, array $requestParameters, PDO $dbh): ?Form
{
	if($_SERVER["REQUEST_METHOD"] == "POST") // If POST parameters are given, try to update a record
	{
		/* Validate record */
		$submittedForm = $table->constructForm();
		$submittedForm->importValues($_POST);
		$submittedForm->checkFields();

		/* Update the record if it is valid */
		if($submittedForm->checkValid())
		{
			$item = $submittedForm->exportValues();
			TodoItem::update($dbh, $item);
		}

		return $submittedForm;
	}
	else if(array_key_exists("__operation", $_GET))
	{
		if($_GET["__operation"] == "delete")
		{
			$id = $requestParameters["ITEM_ID"];

			if($id == "")
				throw new Exception("No ITEM_ID specified!");
			else
			{
				TodoItem::delete($dbh, $id);

				header("Location: todoitems.php?".http_build_query(array(
					"page" => $requestParameters["page"]
				), null, "", PHP_QUERY_RFC3986).AnchorRow::composePreviousRowFragment());
				exit;
			}
		}
		else
			throw new Exception("Unknown operation: ".$_GET["__operation"]);
	}

	return null;
}

$error = null;

try
{
	$requestParameters = importAndCheckParameters();
	$table = constructTable($dbh, $pageSize, $requestParameters);
	$submittedForm = executeOperation($table, $requestParameters, $dbh);
}
catch(Exception $ex)
{
	$error = $ex->getMessage();
}

/* Display the page and table */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>TODO List</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<h1>TODO List</h1>

		<?php
		if($error !== null)
		{
			?>
			<p><?= $error ?></p>
			<?php
		}
		else if(($stmt = TodoItem::queryPage($dbh, (int)$requestParameters["page"], $pageSize)) !== false)
		{
			$table->stmt = $stmt;

			if($requestParameters["viewmode"] == 1) // If viewmode is selected, display ordinary table
			{
				?>
				<p><a href="<?= $_SERVER["PHP_SELF"] ?>?viewmode=2&amp;page=<?= $requestParameters["page"] ?>">Semi edit</a></p>
				<?php
				\SBData\View\HTML\displayPagedDBTable($table, $requestParameters);
			}
			else if($requestParameters["viewmode"] == 2) // If semi-edit mode is selected, display ordinary table with delete links
			{
				?>
				<p>
					<a href="todoitem.php">Add TODO item</a> |
					<a href="<?= $_SERVER["PHP_SELF"] ?>?page=<?= $requestParameters["page"] ?>">Edit</a>
				</p>
				<?php
				\SBData\View\HTML\displaySemiEditablePagedDBTable($table, $requestParameters);
			}
			else
			{
				?>
				<p>
					<a href="todoitem.php">Add TODO item</a> |
					<a href="<?= $_SERVER["PHP_SELF"] ?>?viewmode=1&amp;page=<?= $requestParameters["page"] ?>">View</a>
				</p>
				<?php
				\SBData\View\HTML\displayEditablePagedDBTable($table, $requestParameters, $submittedForm);
			}
		}
		else
		{
			?>
			<p>Cannot query any TODO items from the database!</p>
			<?php
		}
		?>
	</body>
</html>
