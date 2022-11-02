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
	if($field->exportValue() == $field->value->checkedValue)
		print("&check;");
}

function displayEditableCheckBoxField(string $name, CheckBoxField $field): void
{
	$value = $field->exportValue();
	?>
	<input name="<?= $name ?>" type="checkbox" value="<?= $field->value->checkedValue ?>"<?php if(($value === null && $field->initiallyChecked) || $value == $field->value->checkedValue) print(" checked"); ?>>
	<?php
}

/**
 * @}
 */
?>
