<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");
require_once("includes/db.php");

use SBData\Model\Form;
use SBData\Model\Field\ReadOnlyNumericIntTextField;
use SBData\Model\Field\TextField;
use SBData\Model\Field\ComboBoxField\DBComboBoxField;
use Examples\Books\Entity\Book;
use Examples\Books\Entity\Publisher;

if(array_key_exists("viewmode", $_GET) && $_GET["viewmode"] == "1")
	$stmt = Book::queryOnePublisher($dbh, $_GET["BOOK_ID"]); // In view mode we need to query the corresponding publisher name
else
	$stmt = Publisher::queryAll($dbh); // In edit mode we need to know all selectable publishers

/* Define a form model */

$idField = new ReadOnlyNumericIntTextField("Id", false, 20, 255);

$form = new Form(array(
	"BOOK_ID" => $idField,
	"Title" => new TextField("Title", true),
	"Subtitle" => new TextField("Subtitle", false, 30, 255),
	"PUBLISHER_ID" => new DBComboBoxField("Publisher", $stmt, true),
));

if(count($_POST) > 0) // Insert or update a book if POST parameters are provided
{
	$form->importValues($_POST);
	$form->checkFields();
	
	if($form->checkValid())
	{
		$book = $form->exportValues();
		$bookId = $form->fields["BOOK_ID"]->exportValue();

		if($bookId == "") // Empty book id means insert operation
			Book::insert($dbh, $book);
		else // Otherwise update the book
			Book::update($dbh, $book);

		header("Location: books.php");
		exit;
	}
}
else if(count($_GET) > 0) // If a book id through a GET parameter is provided, display the requested book
{
	$idField->importValue($_GET["BOOK_ID"]);
	
	if($idField->checkField("BOOK_ID"))
	{
		$bookId = $idField->exportValue();
		$stmt = Book::queryOne($dbh, $bookId);

		if(($book = $stmt->fetch()) !== false)
			$form->importValues($book);
	}
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
		<?php
		if(array_key_exists("viewmode", $_GET) && $_GET["viewmode"] == "1")
			\SBData\View\HTML\displayForm($form);
		else
			\SBData\View\HTML\displayEditableForm($form, "Submit", "One or more fields are incorrectly specified and marked with a red color!", "This field is incorrectly specified!");
		?>
	</body>
</html>
