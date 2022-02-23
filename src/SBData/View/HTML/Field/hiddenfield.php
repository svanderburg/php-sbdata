<?php
/**
 * @file
 * @brief View-HTML-Field-HiddenField module
 * @defgroup View-HTML-Field-HiddenField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\HiddenField;

function displayHiddenField(string $name, HiddenField $field): void
{
	?>
	<div style="display: none;"><input name="<?php print($name); ?>" type="hidden" value="<?php print(htmlentities($field->value)); ?>"></div>
	<?php
}

/**
 * @}
 */
?>
