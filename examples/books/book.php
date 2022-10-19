<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");
require_once("includes/db.php");

use SBData\Model\ParameterMap;
use SBData\Model\Value\IntegerValue;
use SBData\Model\Form;
use SBData\Model\Field\ReadOnlyNumericIntTextField;
use SBData\Model\Field\TextField;
use SBData\Model\Field\HiddenField;
use SBData\Model\Field\ComboBoxField\DBComboBoxField;
use Examples\Books\Entity\Book;
use Examples\Books\Entity\Publisher;

function importAndCheckParameters(): ParameterMap
{
	$getMap = new ParameterMap(array(
		"viewmode" => new IntegerValue(false),
		"BOOK_ID" => new IntegerValue(false, 255)
	));
	$getMap->importValues($_GET);
	$getMap->checkValues();

	if($getMap->checkValid())
		return $getMap;
	else
		throw new Exception($getMap->composeErrorMessage("The following parameters are invalid:"));
}

function constructForm(ParameterMap $getMap, PDO $dbh): Form
{
	if($getMap->values["viewmode"]->value == 1)
		$stmt = Book::queryOnePublisher($dbh, $getMap->values["BOOK_ID"]->value); // In view mode we need to query the corresponding publisher name
	else
		$stmt = Publisher::queryAll($dbh); // In edit mode we need to know all selectable publishers

	return new Form(array(
		"__operation" => new HiddenField(false),
		"BOOK_ID" => new ReadOnlyNumericIntTextField("Id", false, 20, 255),
		"Title" => new TextField("Title", true),
		"Subtitle" => new TextField("Subtitle", false, 30, 255),
		"PUBLISHER_ID" => new DBComboBoxField("Publisher", $stmt, true),
	));
}

function executeOperation(ParameterMap $getMap, Form $form, PDO $dbh): void
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

				header("Location: ".$_SERVER["PHP_SELF"]."?".http_build_query(array(
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
		$bookId = $getMap->values["BOOK_ID"]->value;

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
	$getMap = importAndCheckParameters();
	$form = constructForm($getMap, $dbh);
	executeOperation($getMap, $form, $dbh);
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
			<a href="<?php print($_SERVER["PHP_SELF"]); ?>">Add book</a>
		</p>
		<?php
		if($error === null)
		{
			if($getMap->values["viewmode"]->value == 1)
				\SBData\View\HTML\displayForm($form);
			else
				\SBData\View\HTML\displayEditableForm($form, "Submit", "One or more fields are incorrectly specified and marked with a red color!", "This field is incorrectly specified!");
			}
		else
		{
			?>
			<p><?php print($error); ?></p>
			<?php
		}
		?>
	</body>
</html>
