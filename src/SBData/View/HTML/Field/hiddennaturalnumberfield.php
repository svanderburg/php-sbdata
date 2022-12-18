<?php
/**
 * @file
 * @brief View-HTML-Field-HiddenNaturalNumberField module
 * @defgroup View-HTML-Field-HiddenNaturalNumberField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\HiddenNaturalNumberField;

function displayEditableHiddenNaturalNumberFieldRow(string $name, bool $inline, HiddenNaturalNumberField $field): void
{
	displayEditableGenericHiddenFieldRow($name, $inline, $field);
}

/**
 * @}
 */
?>
