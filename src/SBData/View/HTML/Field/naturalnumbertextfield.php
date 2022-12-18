<?php
/**
 * @file
 * @brief View-HTML-Field-NaturalNumberTextField module
 * @defgroup View-HTML-Field-NaturalNumberTextField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\NaturalNumberTextField;

function displayNaturalNumberTextField(NaturalNumberTextField $field): void
{
	displayGenericTextField($field);
}

function displayEditableNaturalNumberTextField(string $name, NaturalNumberTextField $field): void
{
	displayEditableGenericTextField($name, $field);
}

/**
 * @}
 */
?>
