<?php
/**
 * @file
 * @brief View-HTML-Field-PasswordField module
 * @defgroup View-HTML-Field-PasswordField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\PasswordField;

function displayPasswordField(PasswordField $field): void
{
	// Never display a password
}

function displayEditablePasswordField(string $name, PasswordField $field): void
{
	?>
	<input name="<?= $name ?>" type="password" size="<?= $field->size ?>"<?php if($field->value->maxlength !== null) print(' maxlength="'.$field->value->maxlength.'"'); ?>>
	<?php
}

/**
 * @}
 */
?>
