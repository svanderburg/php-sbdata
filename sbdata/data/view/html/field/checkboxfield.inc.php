<?php
function displayCheckBoxField(CheckBoxField $field)
{
	if($field->value == $field->checkedValue)
		print("&check;");
}

function displayEditableCheckBoxField($name, CheckBoxField $field)
{
	?>
	<input name="<?php print($name); ?>" type="checkbox" value="<?php print($field->checkedValue); ?>"<?php if($field->value == $field->checkedValue) print(" checked"); ?>>
	<?php
}
?>
