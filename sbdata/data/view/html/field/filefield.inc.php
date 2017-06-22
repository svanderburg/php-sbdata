<?php
require_once("textfield.inc.php");

function displayFileField(FileField $field)
{
	displayTextField($field);
}

function displayEditableFileField($name, FileField $field)
{
	?>
	<input name="<?php print($name); ?>" type="file" value="<?php print(htmlentities($field->value)); ?>">
	<?php
}
?>
