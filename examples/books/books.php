<?php
error_reporting(E_STRICT | E_ALL);

set_include_path("../../sbdata");

require_once("includes/db.inc.php");
require_once("includes/entity/Book.class.php");
require_once("data/model/table/DBTable.class.php");
require_once("data/model/field/KeyLinkField.class.php");
require_once("data/model/field/TextField.class.php");
require_once("data/model/field/NumericIntTextField.class.php");

function composeBookLink(KeyLinkField $field, Form $form)
{
	/* Determine the URL for edit or view mode */
	if(array_key_exists("viewmode", $_GET) && $_GET["viewmode"] == "1")
		return "book.php?viewmode=1&amp;BOOK_ID=".$field->value;
	else
		return "book.php?BOOK_ID=".$field->value;
}

/* Configure a table model */

$idField = new KeyLinkField("Id", "composeBookLink", true, 20, 255);

$table = new DBTable(array(
	"BOOK_ID" => $idField,
	"Title" => new TextField("Title", true, 30, 255),
	"Subtitle" => new TextField("Subtitle", false, 30, 255),
	"PUBLISHER_ID" => new NumericIntTextField("Publisher", true, 10),
));

if(count($_POST) > 0) // If POST parameters are given, try to update a record
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
}
else
{
	$submittedForm = null;
	
	if(count($_GET) > 0 && array_key_exists("__operation", $_GET) && array_key_exists("__operation", $_GET) == "delete") // If delete operation is specified, delete the record
	{
		/* Check the field */
		$idField->value = $_GET["BOOK_ID"];
		
		if($idField->checkField("BOOK_ID"))
		{
			Book::delete($dbh, $idField->value);

			header("Location: books.php#table-row-".$_REQUEST["__id"]);
			exit;
		}
	}
}

/* Display the page and table */
require_once("data/view/html/table.inc.php");
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
		if($stmt = Book::queryAll($dbh))
		{
			$table->stmt = $stmt;
			
			if(array_key_exists("viewmode", $_GET) && $_GET["viewmode"] == "1") // If viewmode is selected, display ordinary table
			{
				?>
				<p><a href="<?php print($_SERVER["PHP_SELF"]); ?>?viewmode=2">Semi edit</a></p>
				<?php
				displayTable($table);
			}
			else if(array_key_exists("viewmode", $_GET) && $_GET["viewmode"] == "2") // If semi-edit mode is selected, display ordinary table with delete links
			{
				?>
				<p>
					<a href="book.php">Add book</a> |
					<a href="<?php print($_SERVER["PHP_SELF"]); ?>">Edit</a>
				</p>
				<?php
				function deleteBookLink(Form $form)
				{
					return "?__operation=delete&amp;__id=".$form->fields["__id"]->value."&amp;BOOK_ID=".$form->fields["BOOK_ID"]->value;
				}
				
				displayTable($table, "deleteBookLink");
			}
			else
			{
				?>
				<p>
					<a href="book.php">Add book</a> |
					<a href="<?php print($_SERVER["PHP_SELF"]); ?>?viewmode=1">View</a>
				</p>
				<?php
				function deleteBookLink(Form $form)
				{
					return "?__operation=delete&amp;__id=".$form->fields["__id"]->value."&amp;BOOK_ID=".$form->fields["BOOK_ID"]->value;
				}
				
				displayEditableTable($table, $submittedForm, "deleteBookLink");
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
