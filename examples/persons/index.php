<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");

use SBData\Model\Form;
use SBData\Model\Field\EmailField;
use SBData\Model\Field\HiddenField;
use SBData\Model\Field\NumericIntTextField;
use SBData\Model\Field\TextField;
use SBData\Model\Field\URLField;
use SBData\Model\Table\ArrayTable;

/* Define a table displaying the test rowset */

$idField = new HiddenField("id", true);

function deletePersonLink(Form $form)
{
	return "?__operation=delete&amp;id=".$form->fields["id"]->value;
}

$table = new ArrayTable(array(
	"id" => $idField,
	"firstname" => new TextField("First name", true), 
	"lastname" => new TextField("Last name", true),
	"address" => new TextField("Street", true),
	"number" => new NumericIntTextField("House number", true),
	"zipcode" => new TextField("Zipcode", true, 6, 6),
	"phone" => new TextField("Phone", false, 10, 10),
	"city" => new TextField("City", true),
	"email" => new EmailField("Email"),
	"homepage" => new URLField("Homepage")
), array(
	"Delete" => "deletePersonLink"
));

/* Define a test rowset */
$table->setRows(array(
	array("id" => 1, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "1", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 2, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "2", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 3, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "3", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 4, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "4", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 5, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "5", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 6, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "6", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 7, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "7", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 8, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "8", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 9, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "9", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 10, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "10", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 11, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "11", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 12, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "12", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 13, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "13", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander"),
	array("id" => 14, "firstname" => "Sander", "lastname" => "van der Burg", "address" => "Some steet", "number" => "14", "zipcode" => "1234AB", "city" => "City", "phone" => "0101234567", "email" => "sander@sander.sander", "homepage" => "http://sander")
));

if(count($_POST) > 0) // If an edit has been made, override the test rowset with the change
{
	/* Validate the user input */
	$submittedForm = $table->constructForm();
	$submittedForm->importValues($_POST);
	$submittedForm->checkFields();
	
	if($submittedForm->checkValid()) // If the imput is valid, then use it to modify
	{
		/* Do a linear search for the element that needs to be changed (yes I know it can be done more efficiently, but I'm too lazy to implement a smarter way) */
	
		foreach($table->rows as $row)
		{	
			if($row["id"] == $submittedForm->fields["id"]->value)
			{
				/* Set the updated values for the row */
				$row["firstname"] = $submittedForm->fields["firstname"]->value;
				$row["lastname"] = $submittedForm->fields["lastname"]->value;
				$row["address"] = $submittedForm->fields["address"]->value;
				$row["number"] = $submittedForm->fields["number"]->value;
				$row["zipcode"] = $submittedForm->fields["zipcode"]->value;
				$row["phone"] = $submittedForm->fields["phone"]->value;
				$row["city"] = $submittedForm->fields["city"]->value;
				$row["email"] = $submittedForm->fields["email"]->value;
				$row["homepage"] = $submittedForm->fields["homepage"]->value;
			}
			
			$table->rows[$row["id"]] = $row; // Update the row in the array
		}
	}
}
else
{
	$submittedForm = null;

	if(count($_GET) > 0 && array_key_exists("__operation", $_GET) && $_GET["__operation"] == "delete") // If a delete has been made, delete the element from the array
	{
		/* Check id validity */
		$idField->value = $_GET["id"];
		
		if($idField->checkField("id"))
		{
			/* Do a linear search for the element that needs to be deleted (yes yes, see previous note) */
			$count = 0;
			
			foreach($table->rows as $row)
			{
				if($row["id"] == $idField->value)
				{
					array_splice($table->rows, $count, 1); // Delete the found row
					break;
				}
				
				$count++;
			}
		}
	}
}

/* Display the page and table */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Table test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
		<?php
		if(array_key_exists("viewmode", $_GET) && $_GET["viewmode"] == "1") // If viewmode is selected, display ordinary table
		{
			?>
			<p><a href="<?php print($_SERVER["PHP_SELF"]); ?>">Edit</a></p>
			<?php
			\SBData\View\HTML\displaySemiEditableTable($table);
		}
		else // Otherwise display editable table
		{
			?>
			<p><a href="<?php print($_SERVER["PHP_SELF"]); ?>?viewmode=1">View</a></p>
			<?php
			\SBData\View\HTML\displayEditableTable($table, $submittedForm);
		}
		?>
	</body>
</html>
