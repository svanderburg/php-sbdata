<?php
/**
 * @file
 * @brief View-HTML-Field-AgreeField module
 * @defgroup View-HTML-Field-AgreeField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\AgreeField;

function displayAgreeField(AgreeField $field): void
{
	if($field->exportValue() == $field->value->checkedValue)
		print("&check;");
}

function displayEditableAgreeField(string $name, AgreeField $field): void
{
	$value = $field->exportValue();
	?>
	<input name="<?= $name ?>" type="checkbox" value="<?= $field->value->checkedValue ?>"<?php if($value == $field->value->checkedValue) print(" checked"); ?>>
	<?php
}

/**
 * @}
 */
?>
