<?php
namespace SBData\View\HTML\Field;
use SBData\Model\Field\TextAreaField;

function displayTextAreaField(TextAreaField $field)
{
	displayTextField($field);
}

function displayEditableTextAreaField($name, TextAreaField $field)
{
	?>
	<textarea name="<?php print($name); ?>" cols="<?php print($field->cols); ?>" rows="<?php print($field->rows); ?>"><?php print(htmlentities($field->value)); ?></textarea>
	<?php
}
?>
