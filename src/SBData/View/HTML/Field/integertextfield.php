<?php
/**
 * @file
 * @brief View-HTML-Field-IntegerTextField module
 * @defgroup View-HTML-Field-IntegerTextField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\IntegerTextField;

function displayIntegerTextField(IntegerTextField $field): void
{
	displayGenericTextField($field);
}

function displayEditableIntegerTextField(string $name, IntegerTextField $field): void
{
	displayEditableGenericTextField($name, $field);
}

/**
 * @}
 */
?>
