<?php
namespace SBData\View\HTML\Field;
use SBData\Model\Field\EmailField;

function displayEmailField(EmailField $field)
{
	if($field->value !== "")
	{
		?>
		<a href="mailto:<?php print($field->value); ?>"><?php print(htmlentities($field->value)); ?></a>
		<?php
	}
}

function displayEditableEmailField($name, EmailField $field)
{
	displayEditableTextField($name, $field);
}
?>
