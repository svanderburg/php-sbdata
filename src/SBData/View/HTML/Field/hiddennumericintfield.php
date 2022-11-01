<?php
/**
 * @file
 * @brief View-HTML-Field-HiddenNumericIntField module
 * @defgroup View-HTML-Field-HiddenNumericIntField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\HiddenNumericIntField;

function displayEditableHiddenNumericIntFieldRow(string $name, bool $inline, HiddenNumericIntField $field): void
{
	displayEditableGenericHiddenFieldRow($name, $inline, $field);
}

/**
 * @}
 */
?>
