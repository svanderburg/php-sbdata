<?php
/**
 * @file
 * @brief View-HTML-Field-TextField module
 * @defgroup View-HTML-Field-TextField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\TextField;

function displayTextField(TextField $field): void
{
	print(htmlentities($field->value));
}

function displayEditableTextField(string $name, TextField $field): void
{
	?>
	<input name="<?php print($name); ?>" type="text" value="<?php print(htmlentities($field->value)); ?>" size="<?php print($field->size); ?>"<?php if($field->maxlength !== null) print(' maxlength="'.$field->maxlength.'"'); ?>>
	<?php
}

/**
 * @}
 */
?>
