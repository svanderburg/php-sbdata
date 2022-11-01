<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");

use SBData\Model\Form;
use SBData\Model\Field\AcceptableFileNameField;
use SBData\Model\Field\CheckBoxField;
use SBData\Model\Field\DateField;
use SBData\Model\Field\EmailField;
use SBData\Model\Field\NumericIntTextField;
use SBData\Model\Field\TextField;
use SBData\Model\Field\TextAreaField;
use SBData\Model\Field\URLField;
use SBData\Model\Field\ComboBoxField\ArrayComboBoxField;

/* Define a form */
$form = new Form(array(
	"firstname" => new TextField("First name", true),
	"lastname" => new TextField("Last name", true),
	"address" => new TextField("Street", true),
	"number" => new NumericIntTextField("House number", true),
	"zipcode" => new TextField("Zipcode", true, 6, 6),
	"phone" => new TextField("Phone", false, 10, 10),
	"city" => new TextField("City", true),
	"country" => new ArrayComboBoxField("Country", array("Netherlands", "Belgium"), true),
	"email" => new EmailField("Email"),
	"homepage" => new URLField("Homepage"),
	"birthdate" => new DateField("Birth date", true, true),
	"drivinglicense" => new CheckBoxField("Driving license", false, "1"),
	"filename" => new AcceptableFileNameField("File name", false, 20, 255),
	"comments" => new TextAreaField("Comments", false, 30, 15)
));

if(count($_POST) > 0)
{
	$form->importValues($_POST);
	$form->checkFields();

	$valid = $form->checkValid();
}

/* Display the page and form */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Form test</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
		<?php
		if(count($_POST) > 0 && $valid)
			\SBData\View\HTML\displayForm($form);
		else
			\SBData\View\HTML\displayEditableForm($form, "Submit", "One or more fields are incorrectly specified and marked with a red color!", "This field is incorrectly specified!");
		?>
	</body>
</html>
