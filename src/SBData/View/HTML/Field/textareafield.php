<?php
/**
 * @file
 * @brief View-HTML-Field-TextAreaField module
 * @defgroup View-HTML-Field-TextAreaField
 * @{
 */
namespace SBData\View\HTML\Field;
use SBData\Model\Field\TextAreaField;

function displayTextAreaField(TextAreaField $field): void
{
	displayGenericTextAreaField($field);
}

function displayEditableTextAreaField(string $name, TextAreaField $field): void
{
	displayEditableGenericTextAreaField($name, $field);
}

/**
 * @}
 */
?>
