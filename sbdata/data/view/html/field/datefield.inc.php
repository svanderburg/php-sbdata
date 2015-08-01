<?php
require_once("textfield.inc.php");

function displayDateField(TextField $field)
{
	displayTextField($field);
}

function displayEditableDateField($name, TextField $field)
{
	displayEditableTextField($name, $field);
}
?>
