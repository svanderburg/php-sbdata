<?php
/**
 * @file
 * @brief View-HTML-Field-HiddenField module
 * @defgroup View-HTML-Field-HiddenField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\HiddenField;

function displayHiddenField(string $name, HiddenField $field): void
{
	displayGenericHiddenField($name, $field);
}

/**
 * @}
 */
?>
