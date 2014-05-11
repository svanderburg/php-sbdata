<?php
require_once("field/hiddenfield.inc.php");
require_once("field/textareafield.inc.php");
require_once("field/filefield.inc.php");
require_once("field/textfield.inc.php");
require_once("field/urlfield.inc.php");
require_once("field/emailfield.inc.php");
require_once("field/comboboxfield/arraycomboboxfield.inc.php");
require_once("field/comboboxfield/dbcomboboxfield.inc.php");

/**
 * Displays a field in a non-editable way.
 * 
 * @param Field $field Field to display
 */
function displayField(Field $field)
{
	if($field instanceof KeyLinkField)
		displayKeyLinkField($field);
	else if($field instanceof EmailField)
		displayEmailField($field);
	else if($field instanceof URLField)
		displayURLField($field);
	else if($field instanceof ArrayComboBoxField)
		displayArrayComboBoxField($field);
	else if($field instanceof DBComboBoxField)
		displayDBComboBoxField($field);
	else if($field instanceof TextField)
		displayTextField($field);
}

/**
 * Displays a field in a editable way.
 *
 * @param Field $field Field to display
 */
function displayEditableField($name, Field $field)
{
	if($field instanceof KeyLinkField)
		displayEditableKeyLinkField($name, $field);
	else if($field instanceof TextAreaField)
		displayEditableTextAreaField($name, $field);
	else if($field instanceof FileField)
		displayEditableFileField($name, $field);
	else if($field instanceof DBComboBoxField)
		displayEditableDBComboBoxField($name, $field);
	else if($field instanceof ArrayComboBoxField)
		displayEditableArrayComboBoxField($name, $field);
	else if($field instanceof TextField)
		displayEditableTextField($name, $field);
}
?>
