<?php
require_once("textfield.inc.php");

function displayURLField(TextField $field)
{
	if($field->value !== "")
	{
		?>
		<a href="<?php print($field->value); ?>"><?php print(htmlentities($field->value)); ?></a>
		<?php
	}
}

function displayEditableURLField($name, TextField $field)
{
	displayEditableTextField($name, $field);
}
?>
