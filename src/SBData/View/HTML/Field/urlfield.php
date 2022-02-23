<?php
/**
 * @file
 * @brief View-HTML-Field-URLField module
 * @defgroup View-HTML-Field-URLField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\URLField;

function displayURLField(URLField $field): void
{
	if($field->value !== "")
	{
		?>
		<a href="<?php print($field->value); ?>"><?php print(htmlentities($field->value)); ?></a>
		<?php
	}
}

function displayEditableURLField(string $name, URLField $field): void
{
	displayEditableTextField($name, $field);
}

/**
 * @}
 */
?>
