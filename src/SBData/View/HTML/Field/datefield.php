<?php
/**
 * @file
 * @brief View-HTML-Field-DateField module
 * @defgroup View-HTML-Field-DateField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\DateField;

function displayDateField(DateField $field): void
{
	displayTextField($field);
}

function displayEditableDateField(string $name, DateField $field): void
{
	displayEditableTextField($name, $field);
}

/**
 * @}
 */
?>
