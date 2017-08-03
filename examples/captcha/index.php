<?php
error_reporting(E_STRICT | E_ALL);

require(dirname(__FILE__)."/../../vendor/autoload.php");

use SBData\Model\Form;
use SBData\Model\Field\EmailField;
use Examples\CAPTCHA\Model\Field\CAPTCHAField;

/* Define a form */
$form = new Form(array(
	"email" => new EmailField("Email", true),
	"code" => new CAPTCHAField("Code", "Please provde the code shown in the picture", 5)
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
