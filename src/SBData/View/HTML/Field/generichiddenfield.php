<?php
/**
 * @file
 * @brief View-HTML-Field-GenericHiddenField module
 * @defgroup View-HTML-Field-GenericHiddenField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\GenericHiddenField;

function displayGenericHiddenField(GenericHiddenField $field): void
{
	// Do nothing
}

function displayEditableGenericHiddenField(string $name, GenericHiddenField $field): void
{
	?>
	<div style="display: none;"><input name="<?php print($name); ?>" type="hidden" value="<?php print(htmlentities($field->exportValue())); ?>"></div>
	<?php
}

/**
 * @}
 */
?>
