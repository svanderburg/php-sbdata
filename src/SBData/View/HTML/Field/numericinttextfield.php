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
	displayTextField($field);
}

function displayEditableNumericIntTextField(string $name, NumericIntTextField $field): void
{
	displayEditableTextField($name, $field);
}

/**
 * @}
 */
?>
