<?php
/**
 * @file
 * @brief View-HTML-Field-DutchZipCodeField module
 * @defgroup View-HTML-Field-DutchZipCodeField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\DutchZipCodeField;

function displayDutchZipCodeField(DutchZipCodeField $field): void
{
	displayGenericTextField($field);
}

function displayEditableDutchZipCodeField(string $name, DutchZipCodeField $field): void
{
	displayEditableGenericTextField($name, $field);
}

/**
 * @}
 */
?>
