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
	<textarea name="<?= $name ?>" cols="<?= $field->cols ?>" rows="<?= $field->rows ?>"<?php if($field->value->maxlength !== null) print(' maxlength="'.$field->value->maxlength.'"'); ?>><?= htmlentities($field->exportValue()) ?></textarea>
	<?php
}

/**
 * @}
 */
?>
