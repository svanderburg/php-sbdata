<?php
/**
 * @file
 * @brief View-HTML-Field-IPAddressField module
 * @defgroup View-HTML-Field-IPAddressField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\IPAddressField;

function displayIPAddressField(IPAddressField $field): void
{
	displayGenericTextField($field);
}

function displayEditableIPAddressField(string $name, IPAddressField $field): void
{
	displayEditableGenericTextField($name, $field);
}

/**
 * @}
 */
?>
