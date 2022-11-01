<?php
/**
 * @file
 * @brief View-HTML-Field-AcceptableFileNameField module
 * @defgroup View-HTML-Field-AcceptableFileNameField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\AcceptableFileNameField;

function displayAcceptableFileNameField(AcceptableFileNameField $field): void
{
	displayGenericTextField($field);
}

function displayEditableAcceptableFileNameField(string $name, AcceptableFileNameField $field): void
{
	displayEditableGenericTextField($name, $field);
}

/**
 * @}
 */
?>
