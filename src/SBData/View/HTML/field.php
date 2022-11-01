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
 * Displays an entire row for a field in an editable way. This is used for displaying non-visible fields.
 *
 * @param $name Name of the field
 * @param $inline Indicates whether to generate an inline element for the row
 * @param $field Field to display
 * @param $form Form where the field belongs to (optional)
 */
function displayEditableFieldRow(string $name, bool $inline, Field $field, Form $form = null): void
{
	/* Dynamically invoke the corresponding the display function belonging to the given class */
	$reflect = new ReflectionClass($field);
	$functionName = '\\'.$field->package."\View\HTML\Field\displayEditable".$reflect->getShortName()."Row";
	$functionName($name, $inline, $field, $form);
}

/**
 * @}
 */
?>
