<?php
/**
 * @file
 * @brief View-HTML-Field-TextAreaField module
 * @defgroup View-HTML-Field-TextAreaField
 * @{
 */
namespace SBData\View\HTML\Field;
use SBData\Model\Field\GenericTextAreaField;

function displayGenericTextAreaField(GenericTextAreaField $field): void
{
	print(htmlentities($field->exportValue()));
}

function displayEditableGenericTextAreaField(string $name, GenericTextAreaField $field): void
{
	?>
	<textarea name="<?php print($name); ?>" cols="<?php print($field->cols); ?>" rows="<?php print($field->rows); ?>"<?php if($field->value->maxlength !== null) print(' maxlength="'.$field->value->maxlength.'"'); ?>><?php print(htmlentities($field->exportValue())); ?></textarea>
	<?php
}

/**
 * @}
 */
?>
