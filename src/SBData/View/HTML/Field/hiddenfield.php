<?php
/**
 * @file
 * @brief View-HTML-Field-HiddenField module
 * @defgroup View-HTML-Field-HiddenField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\HiddenField;

function displayHiddenField(HiddenField $field): void
{
	displayGenericHiddenField($field);
}

function displayEditableHiddenField(string $name, HiddenField $field): void
{
	displayEditableGenericHiddenField($name, $field);
}

/**
 * @}
 */
?>
