<?php
error_reporting(E_STRICT | E_ALL);

set_include_path("../../sbdata");

require_once("includes/db.inc.php");
require_once("includes/entity/Publisher.class.php");
require_once("includes/entity/Book.class.php");
require_once("data/model/Form.class.php");
require_once("data/model/field/TextField.class.php");
require_once("data/model/field/HiddenField.class.php");
require_once("data/model/field/comboboxfield/DBComboBoxField.class.php");

if(array_key_exists("viewmode", $_GET) && $_GET["viewmode"] == "1")
	$stmt = Book::queryOnePublisher($dbh, $_GET["BOOK_ID"]); // In view mode we need to query the corresponding publisher name
else
	$stmt = Publisher::queryAll($dbh); // In edit mode we need to know all selectable publishers

/* Define a form model */

$idField = new HiddenField(false);

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
		
		if($form->fields["BOOK_ID"]->value == "") // Empty book id means insert operation
			Book::insert($dbh, $book);
		else // Otherwise update the book
			Book::update($dbh, $book);
		
		header("Location: books.php");
		exit;
	}
}
else if(count($_GET) > 0) // If a book id through a GET parameter is provided, display the requested book
{
	$idField->value = $_GET["BOOK_ID"];
	
	if($idField->checkField("BOOK_ID"))
	{
		$stmt = Book::queryOne($dbh, $idField->value);

		if(($book = $stmt->fetch()) !== false)
			$form->importValues($book);
	}
}
/* Display the page and form */
require_once("data/view/html/form.inc.php");
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
			displayForm($form);
		else
			displayEditableForm($form, "Submit", "One or more fields are incorrectly specified and marked with a red color!", "This field is incorrectly specified!");
		?>
	</body>
</html>
