<?php
/**
 * @file
 * @brief View-HTML-Field-ReadOnlyNumericIntTextField module
 * @defgroup View-HTML-Field-ReadOnlyNumericIntTextField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\ReadOnlyNumericIntTextField;

function displayReadOnlyNumericIntTextField(ReadOnlyNumericIntTextField $field): void
{
	displayNumericIntTextField($field);
}

function displayEditableReadOnlyNumericIntTextField(string $name, ReadOnlyNumericIntTextField $field): void
{
	?>
	<input name="<?= $name ?>" type="text" value="<?= htmlentities($field->exportValue()) ?>" size="<?= $field->size ?>"<?php if($field->value->maxlength !== null) print(' maxlength="'.$field->value->maxlength.'"'); ?> readonly>
	<?php
}

/**
 * @}
 */
?>
