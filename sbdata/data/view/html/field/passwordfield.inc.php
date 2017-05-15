<?php
function displayPasswordField(TextField $field)
{
	// Never display a password
}

function displayEditablePasswordField($name, TextField $field)
{
	?>
	<input name="<?php print($name); ?>" type="password" size="<?php print($field->size); ?>"<?php if($field->maxlength !== null) print(' maxlength="'.$field->maxlength.'"'); ?>>
	<?php
}
?>
