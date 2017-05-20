<?php
require_once("field/datefield.inc.php");
require_once("field/hiddenfield.inc.php");
require_once("field/textareafield.inc.php");
require_once("field/filefield.inc.php");
require_once("field/textfield.inc.php");
require_once("field/urlfield.inc.php");
require_once("field/emailfield.inc.php");
require_once("field/numericinttextfield.inc.php");
require_once("field/readonlynumericinttextfield.inc.php");
require_once("field/passwordfield.inc.php");
require_once("field/checkboxfield.inc.php");
require_once("field/comboboxfield/arraycomboboxfield.inc.php");
require_once("field/comboboxfield/dbcomboboxfield.inc.php");

/**
 * Displays a field in a non-editable way.
 * 
 * @param Field $field Field to display
 */
function displayField(Field $field)
{
	/* Dynamically invoke the corresponding the display function belonging to the given class */
	$functionName = "display".get_class($field);
	$functionName($field);
}

/**
 * Displays a field in an editable way.
 *
 * @param Field $field Field to display
 */
function displayEditableField($name, Field $field)
{
	/* Dynamically invoke the corresponding the display function belonging to the given class */
	$functionName = "displayEditable".get_class($field);
	$functionName($name, $field);
}
?>
