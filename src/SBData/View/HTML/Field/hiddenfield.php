<?php
/**
 * @file
 * @brief View-HTML-Field-HiddenField module
 * @defgroup View-HTML-Field-HiddenField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\HiddenField;

function displayEditableHiddenFieldRow(string $name, bool $inline, HiddenField $field): void
{
	displayEditableGenericHiddenFieldRow($name, $inline, $field);
}

/**
 * @}
 */
?>
