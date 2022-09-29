<?php
/**
 * @file
 * @brief View-HTML-Field-KeyLinkField module
 * @defgroup View-HTML-Field-KeyLinkField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Form;
use SBData\Model\Field\KeyLinkField;

function displayKeyLinkField(KeyLinkField $field, Form $form): void
{
	displayGenericKeyLinkField($field, $form);
}

function displayEditableKeyLinkField(string $name, KeyLinkField $field, Form $form): void
{
	displayEditableGenericKeyLinkField($name, $field, $form);
}

/**
 * @}
 */
?>
