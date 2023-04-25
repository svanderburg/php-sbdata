<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");
require_once("includes/db.php");

use SBData\Model\Form;
use SBData\Model\Table\DBTable;
use SBData\Model\Field\MetaDataField;
use SBData\Model\Field\NaturalNumberKeyLinkField;
use SBData\Model\Field\TextField;
use Examples\Books\Entity\Book;

$composeBookLinkFunction = function (NaturalNumberKeyLinkField $field, Form $form): string
{
	$bookId = $field->exportValue();
	return "book.php?".http_build_query(array(
		"viewmode" => 1,
		"BOOK_ID" => $bookId
	), "", "&amp;", PHP_QUERY_RFC3986);
};

$composePublisherLinkFunction = function (NaturalNumberKeyLinkField $field, Form $form): string
{
	$publisherId = $form->fields["PUBLISHER_ID"]->exportValue();
	return "publisher.php?".http_build_query(array(
		"PUBLISHER_ID" => $publisherId
	), "", "&amp;", PHP_QUERY_RFC3986);
};

/* Configure a table model */

$table = new DBTable(array(
	"BOOK_ID" => new NaturalNumberKeyLinkField("Id", $composeBookLinkFunction, true, 255),
	"Title" => new TextField("Title", true, 30, 255),
	"Subtitle" => new TextField("Subtitle", false, 30, 255),
	"PUBLISHER_ID" => new MetaDataField(true, 255),
	"PublisherName" => new NaturalNumberKeyLinkField("Publisher", $composePublisherLinkFunction, true, 255)
));

/* Display the page and table */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Browse books</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="styles/style.css">
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
