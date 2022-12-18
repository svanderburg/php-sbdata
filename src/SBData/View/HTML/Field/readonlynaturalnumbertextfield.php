<?php
/**
 * @file
 * @brief View-HTML-Field-ReadOnlyNaturalNumberTextField module
 * @defgroup View-HTML-Field-ReadOnlyNaturalNumberTextField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\ReadOnlyNaturalNumberTextField;

function displayReadOnlyNaturalNumberTextField(ReadOnlyNaturalNumberTextField $field): void
{
	displayNaturalNumberTextField($field);
}

function displayEditableReadOnlyNaturalNumberTextField(string $name, ReadOnlyNaturalNumberTextField $field): void
{
	?>
	<input name="<?= $name ?>" type="text" value="<?= htmlentities($field->exportValue()) ?>" size="<?= $field->size ?>"<?php if($field->value->maxlength !== null) print(' maxlength="'.$field->value->maxlength.'"'); ?> readonly>
	<?php
}

/**
 * @}
 */
?>
