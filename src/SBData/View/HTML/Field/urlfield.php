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
	$value = $field->exportValue();

	if($value !== "")
	{
		?>
		<a href="<?php print($value); ?>"><?php print(htmlentities($value)); ?></a>
		<?php
	}
}

function displayEditableURLField(string $name, URLField $field): void
{
	displayEditableGenericTextField($name, $field);
}

/**
 * @}
 */
?>
