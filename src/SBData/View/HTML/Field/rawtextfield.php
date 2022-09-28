<?php
/**
 * @file
 * @brief View-HTML-Field-RawTextField module
 * @defgroup View-HTML-Field-RawTextField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\RawTextField;

function displayRawTextField(RawTextField $field): void
{
	displayGenericTextField($field);
}

function displayEditableRawTextField(string $name, RawTextField $field): void
{
	displayEditableGenericTextField($name, $field);
}

/**
 * @}
 */
?>
