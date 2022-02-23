<?php
/**
 * @file
 * @brief View-HTML-Field-CheckBoxField module
 * @defgroup View-HTML-Field-CheckBoxField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\CheckBoxField;

function displayCheckBoxField(CheckBoxField $field): void
{
	if($field->value == $field->checkedValue)
		print("&check;");
}

function displayEditableCheckBoxField(string $name, CheckBoxField $field): void
{
	?>
	<input name="<?php print($name); ?>" type="checkbox" value="<?php print($field->checkedValue); ?>"<?php if(($field->value === null && $field->initiallyChecked) || $field->value == $field->checkedValue) print(" checked"); ?>>
	<?php
}

/**
 * @}
 */
?>
