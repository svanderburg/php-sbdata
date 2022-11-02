<?php
/**
 * @file
 * @brief View-HTML-Field-HiddenAcceptableFileNameField module
 * @defgroup View-HTML-Field-HiddenAcceptableFileNameField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\HiddenAcceptableFileNameField;

function displayEditableHiddenAcceptableFileNameFieldRow(string $name, bool $inline, HiddenAcceptableFileNameField $field): void
{
	displayEditableGenericHiddenFieldRow($name, $inline, $field);
}

/**
 * @}
 */
?>
