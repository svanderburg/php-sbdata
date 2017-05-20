<?php
require_once("textfield.inc.php");

function displayEmailField(TextField $field)
{
	if($field->value !== "")
	{
		?>
		<a href="mailto:<?php print($field->value); ?>"><?php print(htmlentities($field->value)); ?></a>
		<?php
	}
}

function displayEditableEmailField($name, TextField $field)
{
	displayEditableTextField($name, $field);
}
?>
