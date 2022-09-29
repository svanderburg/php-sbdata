<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");
require_once("includes/db.php");

use SBData\Model\Form;
use SBData\Model\Table\DBTable;
use SBData\Model\Field\MetaDataField;
use SBData\Model\Field\NumericIntKeyLinkField;
use SBData\Model\Field\TextField;
use Examples\Books\Entity\Book;

function composeBookLink(NumericIntKeyLinkField $field, Form $form): string
{
	$bookId = $field->exportValue();
	return "book.php?viewmode=1&amp;BOOK_ID=".$bookId;
}

function composePublisherLink(NumericIntKeyLinkField $field, Form $form): string
{
	$publisherId = $form->fields["PUBLISHER_ID"]->exportValue();
	return "publisher.php?PUBLISHER_ID=".$publisherId;
}

/* Configure a table model */

$table = new DBTable(array(
	"BOOK_ID" => new NumericIntKeyLinkField("Id", "composeBookLink", true, 255),
	"Title" => new TextField("Title", true, 30, 255),
	"Subtitle" => new TextField("Subtitle", false, 30, 255),
	"PUBLISHER_ID" => new MetaDataField(true, 255),
	"PublisherName" => new NumericIntKeyLinkField("Publisher", "composePublisherLink", true, 255)
));

/* Display the page and table */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Browse books</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>

	<body>
		<?php
		if(($stmt = Book::queryOverview($dbh)) !== false)
		{
			$table->stmt = $stmt;
			\SBData\View\HTML\displayTable($table);
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
