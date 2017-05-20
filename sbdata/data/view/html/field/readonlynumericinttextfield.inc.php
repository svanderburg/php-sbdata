<?php
require_once("textfield.inc.php");

function displayReadOnlyNumericIntTextField(TextField $field)
{
	displayTextField($field);
}

function displayEditableReadOnlyNumericIntTextField($name, TextField $field)
{
	?>
	<input name="<?php print($name); ?>" type="text" value="<?php print(htmlentities($field->value)); ?>" size="<?php print($field->size); ?>"<?php if($field->maxlength !== null) print(' maxlength="'.$field->maxlength.'"'); ?> readonly>
	<?php
}
?>
