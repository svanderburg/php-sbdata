<?php
namespace SBData\View\HTML\Field;
use SBData\Model\Field\DateField;

function displayDateField(DateField $field)
{
	displayTextField($field);
}

function displayEditableDateField($name, DateField $field)
{
	displayEditableTextField($name, $field);
}
?>
