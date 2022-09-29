<?php
/**
 * @file
 * @brief View-HTML-Field-NumericIntKeyLinkField module
 * @defgroup View-HTML-Field-NumericIntKeyLinkField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Form;
use SBData\Model\Field\NumericIntKeyLinkField;

function displayNumericIntKeyLinkField(NumericIntKeyLinkField $field, Form $form): void
{
	displayGenericKeyLinkField($field, $form);
}

function displayEditableNumericIntKeyLinkField(string $name, NumericIntKeyLinkField $field, Form $form): void
{
	displayEditableGenericKeyLinkField($name, $field, $form);
}

/**
 * @}
 */
?>
