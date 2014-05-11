<?php
function displayEditableTextAreaField($name, TextAreaField $field)
{
	?>
	<textarea name="<?php print($name); ?>" cols="<?php print($field->cols); ?>" rows="<?php print($field->rows); ?>"><?php print(htmlentities($field->value)); ?></textarea>
	<?php
}
?>
