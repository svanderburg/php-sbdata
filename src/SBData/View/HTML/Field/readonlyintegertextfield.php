<?php
/**
 * @file
 * @brief View-HTML-Field-ReadOnlyIntegerTextField module
 * @defgroup View-HTML-Field-ReadOnlyIntegerTextField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\ReadOnlyIntegerTextField;

function displayReadOnlyIntegerTextField(ReadOnlyIntegerTextField $field): void
{
	displayIntegerTextField($field);
}

function displayEditableReadOnlyIntegerTextField(string $name, ReadOnlyIntegerTextField $field): void
{
	?>
	<input name="<?= $name ?>" type="text" value="<?= htmlentities($field->exportValue()) ?>" size="<?= $field->size ?>"<?php if($field->value->maxlength !== null) print(' maxlength="'.$field->value->maxlength.'"'); ?> readonly>
	<?php
}

/**
 * @}
 */
?>
