<?php
/**
 * @file
 * @brief View-HTML-Field-IntegerKeyLinkField module
 * @defgroup View-HTML-Field-IntegerKeyLinkField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\ReadOnlyForm;
use SBData\Model\Form;
use SBData\Model\Field\IntegerKeyLinkField;

function displayIntegerKeyLinkField(IntegerKeyLinkField $field, ReadOnlyForm $form): void
{
	displayGenericKeyLinkField($field, $form);
}

function displayEditableIntegerKeyLinkField(string $name, IntegerKeyLinkField $field, Form $form): void
{
	displayEditableGenericKeyLinkField($name, $field, $form);
}

/**
 * @}
 */
?>
