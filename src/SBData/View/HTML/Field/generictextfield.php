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
	<input name="<?php print($name); ?>" type="text" value="<?php print(htmlentities($field->exportValue())); ?>" size="<?php print($field->size); ?>"<?php if($field->value->maxlength !== null) print(' maxlength="'.$field->value->maxlength.'"'); ?>>
	<?php
}

/**
 * @}
 */
?>
