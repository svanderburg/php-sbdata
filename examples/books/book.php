<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");
require_once("includes/db.php");

use SBData\Model\ParameterMap;
use SBData\Model\Value\NaturalNumberValue;
use SBData\Model\Form;
use SBData\Model\Field\ReadOnlyNaturalNumberTextField;
use SBData\Model\Field\TextField;
use SBData\Model\Field\HiddenField;
use SBData\Model\Field\ComboBoxField\DBComboBoxField;
use Examples\Books\Entity\Book;
use Examples\Books\Entity\Publisher;

function importAndCheckParameters(): array
{
	$getMap = new ParameterMap(array(
		"viewmode" => new NaturalNumberValue(false),
		"BOOK_ID" => new NaturalNumberValue(false, 255)
	));
	$getMap->importValues($_GET);
	$getMap->checkValues();

	if($getMap->checkValid())
		return $getMap->exportValues();
	else
		throw new Exception($getMap->composeErrorMessage("The following parameters are invalid:"));
}

function constructForm(PDO $dbh): Form
{
	return new Form(array(
		"__operation" => new HiddenField(false),
		"BOOK_ID" => new ReadOnlyNaturalNumberTextField("Id", false, 20, 255),
		"Title" => new TextField("Title", true),
		"Subtitle" => new TextField("Subtitle", false, 30, 255),
		"PUBLISHER_ID" => new DBComboBoxField("Publisher", $dbh, "Examples\\Books\\Entity\\Publisher::queryAll", "Examples\\Books\\Entity\\Publisher::queryOne", true),
	));
}

function executeOperation(array $getParameters, Form $form, PDO $dbh): void
{
	if(array_key_exists("__operation", $_POST))
	{
		if($_POST["__operation"] == "insert_book" || $_POST["__operation"] == "update_book")
		{
			$form->importValues($_POST);
			$form->checkFields();

			if($form->checkValid())
			{
				$book = $form->exportValues();

				if($_POST["__operation"] == "insert_book")
					$bookId = Book::insert($dbh, $book);
				else
				{
					$bookId = $book["BOOK_ID"];
					Book::update($dbh, $book);
				}

				header("Location: ?".http_build_query(array(
					"BOOK_ID" => $bookId
				), "", null, PHP_QUERY_RFC3986));
				exit;
			}
		}
		else
			throw new Exception("Unknown operation: ".$_POST["operation"]);
	}
	else
	{
		$bookId = $getParameters["BOOK_ID"];

		if($bookId == "")
			$form->fields["__operation"]->importValue("insert_book");
		else
		{
			$stmt = Book::queryOne($dbh, $bookId);

			if(($book = $stmt->fetch()) !== false)
				$form->importValues($book);

			$form->fields["__operation"]->importValue("update_book");
		}
	}
}

$error = null;

try
{
	$getParameters = importAndCheckParameters();
	$form = constructForm($dbh);
	executeOperation($getParameters, $form, $dbh);
}
catch(Exception $ex)
{
	$error = $ex->getMessage();
}

/* Display the page and form */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Book</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<p>
			<a href="books.php">&laquo; Books</a> |
			<a href="?">Add book</a>
		</p>
		<?php
		if($error === null)
		{
			if($getParameters["viewmode"] == 1)
				\SBData\View\HTML\displayForm($form);
			else
				\SBData\View\HTML\displayEditableForm($form, "Submit", "One or more fields are incorrectly specified and marked with a red color!", "This field is incorrectly specified!");
			}
		else
		{
			?>
			<p><?= $error ?></p>
			<?php
		}
		?>
	</body>
</html>
