<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");
require_once("includes/db.php");

use SBData\Model\ParameterMap;
use SBData\Model\Value\IntegerValue;
use SBData\Model\Form;
use SBData\Model\Table\DBTable;
use SBData\Model\Table\Anchor\AnchorRow;
use SBData\Model\Field\IntegerKeyLinkField;
use SBData\Model\Field\IntegerTextField;
use SBData\Model\Field\TextField;
use Examples\Books\Entity\Book;

function importAndCheckParameters(): array
{
	$getMap = new ParameterMap(array(
		"viewmode" => new IntegerValue(false),
		"BOOK_ID" => new IntegerValue(false, 255)
	));

	$getMap->importValues($_GET);
	$getMap->checkValues();

	if($getMap->checkValid())
		return $getMap->exportValues();
	else
		throw new Exception($getMap->composeErrorMessage("The following parameters are invalid:"));
}

function constructTable(array $getParameters): DBTable
{
	$composeBookLinkFunction = function (IntegerKeyLinkField $field, Form $form) use ($getParameters): string
	{
		$bookId = $field->exportValue();
		$viewMode = $getParameters["viewmode"];

		/* Determine the URL for edit or view mode */
		if($viewMode == 1)
			return "book.php?".http_build_query(array(
				"viewmode" => 1,
				"BOOK_ID" => $bookId
			), "", "&amp;", PHP_QUERY_RFC3986);
		else
			return "book.php?".http_build_query(array(
				"BOOK_ID" => $bookId
			), "", "&amp;", PHP_QUERY_RFC3986);
	};

	$deleteBookLinkFunction = function (Form $form): string
	{
		$bookId = $form->fields["BOOK_ID"]->exportValue();
		return "?".http_build_query(array(
			"__operation" => "delete",
			"BOOK_ID" => $bookId
		), "", "&amp;", PHP_QUERY_RFC3986).AnchorRow::composeRowParameter($form);
	};

	return new DBTable(array(
		"BOOK_ID" => new IntegerKeyLinkField("Id", $composeBookLinkFunction, true, 20, 255),
		"Title" => new TextField("Title", true, 30, 255),
		"Subtitle" => new TextField("Subtitle", false, 30, 255),
		"PUBLISHER_ID" => new IntegerTextField("Publisher", true, 10),
	), array(
		"Delete" => $deleteBookLinkFunction
	));
}

function executeOperation(DBTable $table, array $getParameters, PDO $dbh): ?Form
{
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		/* Validate record */
		$submittedForm = $table->constructForm();
		$submittedForm->importValues($_POST);
		$submittedForm->checkFields();

		/* Update the record if it is valid */
		if($submittedForm->checkValid())
		{
			$book = $submittedForm->exportValues();
			Book::update($dbh, $book);
		}

		return $submittedForm;
	}
	else if(array_key_exists("__operation", $_GET))
	{
		if($_GET["__operation"] == "delete")
		{
			if($getParameters["BOOK_ID"] == "")
				throw new Exception("No BOOK_ID provided!");
			else
				Book::delete($dbh, $getParameters["BOOK_ID"]);

			header("Location: books.php".AnchorRow::composePreviousRowFragment());
			exit;
		}
		else
			throw new Exception("Unknown operation: ".$_GET["__operation"]);
	}

	return null;
}

$error = null;

try
{
	$getParameters = importAndCheckParameters();
	$table = constructTable($getParameters);
	$submittedForm = executeOperation($table, $getParameters, $dbh);
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
		<title>Books</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
		<?php
		if($error !== null)
		{
			?>
			<p><?= $error ?></p>
			<?php
		}
		else if(($stmt = Book::queryAll($dbh)) !== false)
		{
			$table->stmt = $stmt;

			if($getParameters["viewmode"] == 1) // If viewmode is selected, display ordinary table
			{
				?>
				<p><a href="?viewmode=2">Semi edit</a></p>
				<?php
				\SBData\View\HTML\displayTable($table);
			}
			else if($getParameters["viewmode"] == 2) // If semi-edit mode is selected, display ordinary table with delete links
			{
				?>
				<p>
					<a href="book.php">Add book</a> |
					<a href="?viewmode=0">Edit</a>
				</p>
				<?php
				\SBData\View\HTML\displaySemiEditableTable($table);
			}
			else
			{
				?>
				<p>
					<a href="book.php">Add book</a> |
					<a href="?viewmode=1">View</a>
				</p>
				<?php
				\SBData\View\HTML\displayEditableTable($table, $submittedForm);
			}
		}
		else
		{
			?>
			<p>Cannot query any books from the database!</p>
			<?php
		}
		?>
	</body>
</html>
