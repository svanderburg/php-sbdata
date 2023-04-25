<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");
require_once("includes/db.php");

use SBData\Model\Form;
use SBData\Model\Field\HiddenNaturalNumberField;
use SBData\Model\Field\TextField;
use Examples\Books\Entity\Publisher;

/* Define a form model */

$idField = new HiddenNaturalNumberField(false);

$form = new Form(array(
	"PUBLISHER_ID" => $idField,
	"Name" => new TextField("Title", true, 30, 255)
));

if(count($_GET) > 0) // If a book id through a GET parameter is provided, display the requested book
{
	$idField->importValue($_GET["PUBLISHER_ID"]);

	if($idField->checkField("PUBLISHER_ID"))
	{
		$publisherId = $idField->exportValue();
		$stmt = Publisher::queryOne($dbh, $publisherId);

		if(($publisher = $stmt->fetch()) !== false)
			$form->importValues($publisher);
	}
}
/* Display the page and form */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Book</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="styles/style.css">
	</head>

	<body>
		<?php
		\SBData\View\HTML\displayForm($form);
		?>
	</body>
</html>
