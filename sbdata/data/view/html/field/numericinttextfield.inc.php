<?php
require_once("textfield.inc.php");

function displayNumericIntTextField(TextField $field)
{
	displayTextField($field);
}

function displayEditableNumericIntTextField($name, TextField $field)
{
	displayEditableTextField($name, $field);
}
?>
