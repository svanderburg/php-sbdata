<?php
/**
 * @file
 * @brief View-HTML-Field-EmailField module
 * @defgroup View-HTML-Field-EmailField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\EmailField;

function displayEmailField(EmailField $field): void
{
	if($field->value !== "")
	{
		?>
		<a href="mailto:<?php print($field->value); ?>"><?php print(htmlentities($field->value)); ?></a>
		<?php
	}
}

function displayEditableEmailField(string $name, EmailField $field): void
{
	displayEditableTextField($name, $field);
}

/**
 * @}
 */
?>
