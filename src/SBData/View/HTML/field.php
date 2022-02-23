<?php
/**
 * @file
 * @brief View-HTML-Field module
 * @defgroup View-HTML-Field
 * @{
 */
namespace SBData\View\HTML;
use ReflectionClass;
use SBData\Model\Form;
use SBData\Model\Field\Field;

/**
 * Displays a field in a non-editable way.
 *
 * @param $field Field to display
 * @param $form Form where the field belongs to (optional)
 */
function displayField(Field $field, Form $form = null): void
{
	/* Dynamically invoke the corresponding the display function belonging to the given class */
	$reflect = new ReflectionClass($field);
	$functionName = '\\'.$field->package."\View\HTML\Field\display".$reflect->getShortName();
	$functionName($field, $form);
}

/**
 * Displays a field in an editable way.
 *
 * @param $name Name of the field
 * @param $field Field to display
 * @param $form Form where the field belongs to (optional)
 */
function displayEditableField(string $name, Field $field, Form $form = null): void
{
	/* Dynamically invoke the corresponding the display function belonging to the given class */
	$reflect = new ReflectionClass($field);
	$functionName = '\\'.$field->package."\View\HTML\Field\displayEditable".$reflect->getShortName();
	$functionName($name, $field, $form);
}

/**
 * @}
 */
?>
