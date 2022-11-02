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
	$value = $field->exportValue();

	if($value !== "")
	{
		?>
		<a href="mailto:<?= $value ?>"><?= htmlentities($value) ?></a>
		<?php
	}
}

function displayEditableEmailField(string $name, EmailField $field): void
{
	displayEditableGenericTextField($name, $field);
}

/**
 * @}
 */
?>
