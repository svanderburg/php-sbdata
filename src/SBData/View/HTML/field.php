<?php
namespace SBData\View\HTML;
use ReflectionClass;
use SBData\Model\Form;
use SBData\Model\Field\Field;

/**
 * Displays a field in a non-editable way.
 *
 * @param Field $field Field to display
 * @param Form $form Form where the field belongs to (optional)
 */
function displayField(Field $field, Form $form = null)
{
	/* Dynamically invoke the corresponding the display function belonging to the given class */
	$reflect = new ReflectionClass($field);
	$functionName = "\SBData\View\HTML\Field\display".$reflect->getShortName();
	$functionName($field, $form);
}

/**
 * Displays a field in an editable way.
 *
 * @param Field $field Field to display
 * @param Form $form Form where the field belongs to (optional)
 */
function displayEditableField($name, Field $field, Form $form = null)
{
	/* Dynamically invoke the corresponding the display function belonging to the given class */
	$reflect = new ReflectionClass($field);
	$functionName = "\SBData\View\HTML\Field\displayEditable".$reflect->getShortName();
	$functionName($name, $field, $form);
}
?>
