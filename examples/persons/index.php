<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");

use SBData\Model\ParameterMap;
use SBData\Model\Value\NaturalNumberValue;
use SBData\Model\Form;
use SBData\Model\Field\EmailField;
use SBData\Model\Field\HiddenNaturalNumberField;
use SBData\Model\Field\NaturalNumberTextField;
use SBData\Model\Field\TextField;
use SBData\Model\Field\URLField;
use SBData\Model\Table\Action;
use SBData\Model\Table\EditableArrayTable;

function importAndCheckParameters(): array
{
	$getMap = new ParameterMap(array(
		"viewmode" => new NaturalNumberValue(false),
		"id" => new NaturalNumberValue(false)
	));

	$getMap->importValues($_GET);
	$getMap->checkValues();

	if($getMap->checkValid())
		return $getMap->exportValues();
	else
		throw new Exception($getMap->composeErrorMessage("The following parameters are invalid:"));
}

function constructTable(): EditableArrayTable
{
	$deletePersonLink = function (Form $form): string
	{
		$id = $form->fields["id"]->exportValue();

		return "?".http_build_query(array(
			"__operation" => "delete",
			"id" => $id
		), "", "&amp;", PHP_QUERY_RFC3986);
	};

	$table = new EditableArrayTable(array(
		"id" => new HiddenNaturalNumberField(true),
		"firstname" => new TextField("First name", true),
		"lastname" => new TextField("Last name", true),
		"address" => new TextField("Street", true),
		"number" => new NaturalNumberTextField("House number", true),
		"zipcode" => new TextField("Zipcode", true, 6, 6),
		"phone" => new TextField("Phone", false, 10, 10),
		"city" => new TextField("City", true),
		"email" => new EmailField("Email"),
		"homepage" => new URLField("Homepage")
	), array(
		"Delete" => new Action($deletePersonLink)
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

	/* Return the table */
	return $table;
}

function executeOperation(EditableArrayTable $table, array $getParameters): ?Form
{
	if($_SERVER["REQUEST_METHOD"] == "POST") // If an edit has been made, override the test rowset with the change
	{
		/* Validate the user input */
		$submittedForm = $table->constructForm();
		$submittedForm->importValues($_POST);
		$submittedForm->checkFields();

		if($submittedForm->checkValid()) // If the imput is valid, then use it to modify
		{
			/* Do a linear search for the element that needs to be changed (yes I know it can be done more efficiently, but I'm too lazy to implement a smarter way) */

			$rows = array();

			foreach($table->iterator as $index => $form)
			{
				$row = $form->exportValues();
				$id = $submittedForm->fields["id"]->exportValue();

				if($row["id"] == $id)
				{
					/* Set the updated values for the row */
					$row["firstname"] = $submittedForm->fields["firstname"]->exportValue();
					$row["lastname"] = $submittedForm->fields["lastname"]->exportValue();
					$row["address"] = $submittedForm->fields["address"]->exportValue();
					$row["number"] = $submittedForm->fields["number"]->exportValue();
					$row["zipcode"] = $submittedForm->fields["zipcode"]->exportValue();
					$row["phone"] = $submittedForm->fields["phone"]->exportValue();
					$row["city"] = $submittedForm->fields["city"]->exportValue();
					$row["email"] = $submittedForm->fields["email"]->exportValue();
					$row["homepage"] = $submittedForm->fields["homepage"]->exportValue();
				}

				$rows[$index] = $row; // Update the row in the array
			}

			$table->setRows($rows);
		}

		return $submittedForm;
	}
	else if(array_key_exists("__operation", $_GET))
	{
		if($_GET["__operation"] == "delete")
		{
			$id = $getParameters["id"];

			if($id == "")
				throw new Exception("No id provided!");

			/* Do a linear search for the element that needs to be deleted (yes yes, see previous note) */

			$rows = array();

			foreach($table->iterator as $index => $form)
			{
				$row = $form->exportValues();

				if($row["id"] != $id) // Include all but the deleted row
					$rows[$index] = $row;
			}

			$table->setRows($rows);
		}
		else
			throw new Exception("Unknown operation: ".$_GET["__operation"]);
	}

	return null;
}

$error = null;

try
{
	$getParameters = importAndCheckParameters();
	$table = constructTable($getParameters);
	$submittedForm = executeOperation($table, $getParameters);
}
catch(Exception $ex)
{
	$error = $ex->getMessage();
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
		if($error === null)
		{
			if($getParameters["viewmode"] == 1) // If viewmode is selected, display ordinary table
			{
				?>
				<p><a href="?viewmode=0">Edit</a></p>
				<?php
				\SBData\View\HTML\displaySemiEditableTable($table);
			}
			else // Otherwise display editable table
			{
				?>
				<p><a href="?viewmode=1">View</a></p>
				<?php
				\SBData\View\HTML\displayEditableTable($table, $submittedForm);
			}
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
