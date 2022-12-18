<?php
/**
 * @file
 * @brief View-HTML-Field-HiddenIntegerField module
 * @defgroup View-HTML-Field-HiddenIntegerField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\HiddenIntegerField;

function displayEditableHiddenIntegerFieldRow(string $name, bool $inline, HiddenIntegerField $field): void
{
	displayEditableGenericHiddenFieldRow($name, $inline, $field);
}

/**
 * @}
 */
?>
