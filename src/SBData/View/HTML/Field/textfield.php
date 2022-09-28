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
	displayGenericTextField($field);
}

function displayEditableTextField(string $name, TextField $field): void
{
	displayEditableGenericTextField($name, $field);
}

/**
 * @}
 */
?>
