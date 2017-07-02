<?php
function displayTextField(TextField $field)
{
	print(htmlentities($field->value));
}

function displayEditableTextField($name, TextField $field)
{
	?>
	<input name="<?php print($name); ?>" type="text" value="<?php print(htmlentities($field->value)); ?>" size="<?php print($field->size); ?>"<?php if($field->maxlength !== null) print(' maxlength="'.$field->maxlength.'"'); ?>>
	<?php
}
?>
