<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");
require_once("includes/db.php");

use SBData\Model\Form;
use SBData\Model\Table\DBTable;
use SBData\Model\Table\Anchor\AnchorRow;
use SBData\Model\Field\KeyLinkField;
use SBData\Model\Field\NumericIntTextField;
use SBData\Model\Field\TextField;
use Examples\Books\Entity\Book;

function composeBookLink(KeyLinkField $field, Form $form): string
{
	$bookId = $field->exportValue();

	/* Determine the URL for edit or view mode */
	if(array_key_exists("viewmode", $_GET) && $_GET["viewmode"] == "1")
		return "book.php?viewmode=1&amp;BOOK_ID=".$bookId;
	else
		return "book.php?BOOK_ID=".$bookId;
}

/* Configure a table model */

$idField = new KeyLinkField("Id", "composeBookLink", true, 20, 255);

function deleteBookLink(Form $form): string
{
	$rowId = $form->fields["__id"]->exportValue();
	$bookId = $form->fields["BOOK_ID"]->exportValue();

	return "?__operation=delete&amp;__id=".$rowId."&amp;BOOK_ID=".$bookId.AnchorRow::composePreviousRowParameter($form);
}

$table = new DBTable(array(
	"BOOK_ID" => $idField,
	"Title" => new TextField("Title", true, 30, 255),
	"Subtitle" => new TextField("Subtitle", false, 30, 255),
	"PUBLISHER_ID" => new NumericIntTextField("Publisher", true, 10),
), array(
	"Delete" => "deleteBookLink"
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
		$idField->importValue($_GET["BOOK_ID"]);
		
		if($idField->checkField("BOOK_ID"))
		{
			$id = $idField->exportValue();
			Book::delete($dbh, $id);

			header("Location: books.php".AnchorRow::composeRowFragment());
			exit;
		}
	}
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
		if(($stmt = Book::queryAll($dbh)) !== false)
		{
			$table->stmt = $stmt;
			
			if(array_key_exists("viewmode", $_GET) && $_GET["viewmode"] == "1") // If viewmode is selected, display ordinary table
			{
				?>
				<p><a href="<?php print($_SERVER["PHP_SELF"]); ?>?viewmode=2">Semi edit</a></p>
				<?php
				\SBData\View\HTML\displayTable($table);
			}
			else if(array_key_exists("viewmode", $_GET) && $_GET["viewmode"] == "2") // If semi-edit mode is selected, display ordinary table with delete links
			{
				?>
				<p>
					<a href="book.php">Add book</a> |
					<a href="<?php print($_SERVER["PHP_SELF"]); ?>">Edit</a>
				</p>
				<?php
				\SBData\View\HTML\displaySemiEditableTable($table, true);
			}
			else
			{
				?>
				<p>
					<a href="book.php">Add book</a> |
					<a href="<?php print($_SERVER["PHP_SELF"]); ?>?viewmode=1">View</a>
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
