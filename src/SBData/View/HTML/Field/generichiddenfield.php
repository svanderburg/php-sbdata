<?php
/**
 * @file
 * @brief View-HTML-Field-GenericHiddenField module
 * @defgroup View-HTML-Field-GenericHiddenField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\GenericHiddenField;

function displayEditableGenericHiddenFieldRow(string $name, bool $inline, GenericHiddenField $field): void
{
	if($inline)
		$tag = "span";
	else
		$tag = "div";
	?>
	<<?= $tag ?> style="display: none;"><input name="<?= $name ?>" type="hidden" value="<?= htmlentities($field->exportValue()) ?>"></<?= $tag ?>>
	<?php
}

/**
 * @}
 */
?>
