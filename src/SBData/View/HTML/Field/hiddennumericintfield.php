<?php
/**
 * @file
 * @brief View-HTML-Field-HiddenNumericIntField module
 * @defgroup View-HTML-Field-HiddenNumericIntField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\HiddenNumericIntField;

function displayHiddenNumericIntField(HiddenField $field): void
{
	displayGenericHiddenField($field);
}

function displayEditableHiddenNumericIntField(string $name, HiddenNumericIntField $field): void
{
	displayEditableGenericHiddenField($name, $field);
}

/**
 * @}
 */
?>
