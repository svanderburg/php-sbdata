<?php
/**
 * @file
 * @brief View-HTML-Field-NaturalNumberKeyLinkField module
 * @defgroup View-HTML-Field-NaturalNumberKeyLinkField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\ReadOnlyForm;
use SBData\Model\Form;
use SBData\Model\Field\NaturalNumberKeyLinkField;

function displayNaturalNumberKeyLinkField(NaturalNumberKeyLinkField $field, ReadOnlyForm $form): void
{
	displayGenericKeyLinkField($field, $form);
}

function displayEditableNaturalNumberKeyLinkField(string $name, NaturalNumberKeyLinkField $field, Form $form): void
{
	displayEditableGenericKeyLinkField($name, $field, $form);
}

/**
 * @}
 */
?>
