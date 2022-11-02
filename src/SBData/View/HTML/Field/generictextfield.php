<?php
/**
 * @file
 * @brief View-HTML-Field-GenericTextField module
 * @defgroup View-HTML-Field-GenericTextField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\GenericTextField;

function displayGenericTextField(GenericTextField $field): void
{
	print(htmlentities($field->exportValue()));
}

function displayEditableGenericTextField(string $name, GenericTextField $field): void
{
	?>
	<input name="<?= $name ?>" type="text" value="<?= htmlentities($field->exportValue()) ?>" size="<?= $field->size ?>"<?php if($field->value->maxlength !== null) print(' maxlength="'.$field->value->maxlength.'"'); ?>>
	<?php
}

/**
 * @}
 */
?>
