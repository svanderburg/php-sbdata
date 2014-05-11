<?php
error_reporting(E_STRICT | E_ALL);

set_include_path("../../sbdata");

require_once("data/model/Form.class.php");
require_once("data/model/field/FileField.class.php");

/* Define a form */
$form = new Form(array(
	"file" => new FileField("File", "text/plain", true) 
));

if(count($_FILES) == 1)
{
	$form->importValues($_POST);
	$form->checkFields();
	
	$valid = $form->checkValid();
}

/* Display the page and form */
require_once("data/view/html/form.inc.php");
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
		if(count($_FILES) == 1 && $valid)
		{
			?>
<pre>
<?php
$contents = file_get_contents($_FILES["file"]["tmp_name"]);
print($contents);
?>
</pre>
			<?php
		}
		else
			displayEditableForm($form, "Submit", "One or more fields are incorrectly specified and marked with a red color!", "This field is incorrectly specified!");
		?>
	</body>
</html>
