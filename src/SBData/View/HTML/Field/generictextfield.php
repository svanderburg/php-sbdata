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
	$fieldValue = $field->exportValue();

	if($fieldValue !== null)
		print(htmlentities($fieldValue));
}

function displayEditableGenericTextField(string $name, GenericTextField $field): void
{
	$fieldValue = $field->exportValue();

	if($fieldValue !== null)
		$fieldValue = htmlentities($fieldValue);
	?>
	<input name="<?= $name ?>" type="text" value="<?= $fieldValue ?>" size="<?= $field->size ?>"<?php if($field->value->maxlength !== null) print(' maxlength="'.$field->value->maxlength.'"'); ?>>
	<?php
}

/**
 * @}
 */
?>
