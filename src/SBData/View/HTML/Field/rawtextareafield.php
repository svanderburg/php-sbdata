<?php
/**
 * @file
 * @brief View-HTML-Field-RawTextAreaField module
 * @defgroup View-HTML-Field-RawTextAreaField
 * @{
 */
namespace SBData\View\HTML\Field;
use SBData\Model\Field\RawTextAreaField;

function displayRawTextAreaField(RawTextAreaField $field): void
{
	displayGenericTextAreaField($field);
}

function displayEditableRawTextAreaField(string $name, RawTextAreaField $field): void
{
	displayEditableGenericTextAreaField($name, $field);
}

/**
 * @}
 */
?>
