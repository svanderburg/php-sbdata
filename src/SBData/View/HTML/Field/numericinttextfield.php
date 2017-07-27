<?php
namespace SBData\View\HTML\Field;
use SBData\Model\Field\NumericIntTextField;

function displayNumericIntTextField(NumericIntTextField $field)
{
	displayTextField($field);
}

function displayEditableNumericIntTextField($name, NumericIntTextField $field)
{
	displayEditableTextField($name, $field);
}
?>
