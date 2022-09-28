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
	displayTextField($field);
}

function displayEditableReadOnlyNumericIntTextField(string $name, ReadOnlyNumericIntTextField $field): void
{
	?>
	<input name="<?php print($name); ?>" type="text" value="<?php print(htmlentities($field->value)); ?>" size="<?php print($field->size); ?>"<?php if($field->value->maxlength !== null) print(' maxlength="'.$field->value->maxlength.'"'); ?> readonly>
	<?php
}

/**
 * @}
 */
?>
