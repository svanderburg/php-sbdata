<?php
/**
 * @file
 * @brief View-HTML-Field-NumericIntTextField module
 * @defgroup View-HTML-Field-NumericIntTextField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\NumericIntTextField;

function displayNumericIntTextField(NumericIntTextField $field): void
{
	displayGenericTextField($field);
}

function displayEditableNumericIntTextField(string $name, NumericIntTextField $field): void
{
	displayEditableGenericTextField($name, $field);
}

/**
 * @}
 */
?>
