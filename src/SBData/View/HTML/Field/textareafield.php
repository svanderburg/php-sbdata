<?php
/**
 * @file
 * @brief View-HTML-Field-TextAreaField module
 * @defgroup View-HTML-Field-TextAreaField
 * @{
 */
namespace SBData\View\HTML\Field;
use SBData\Model\Field\TextAreaField;

function displayTextAreaField(TextAreaField $field): void
{
	displayTextField($field);
}

function displayEditableTextAreaField(string $name, TextAreaField $field): void
{
	?>
	<textarea name="<?php print($name); ?>" cols="<?php print($field->cols); ?>" rows="<?php print($field->rows); ?>"><?php print(htmlentities($field->value)); ?></textarea>
	<?php
}

/**
 * @}
 */
?>
