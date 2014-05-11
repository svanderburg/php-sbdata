<?php
function displayEditableFileField($name, FileField $field)
{
	?>
	<input name="<?php print($name); ?>" type="file" value="<?php print(htmlentities($field->value)); ?>">
	<?php
}
?>
