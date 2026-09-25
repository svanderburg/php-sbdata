<?php
/**
 * @file
 * @brief View-HTML-Field-FileField module
 * @defgroup View-HTML-Field-FileField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\FileField;

function displayFileField(FileField $field): void
{
	$value = $field->exportValue();

	if($value !== null)
		print(htmlentities($value));
}

function displayEditableFileField(string $name, FileField $field): void
{
	$value = $field->exportValue();

	?>
	<input name="<?= $name ?>" type="file" value="<?= ($value === null) ? "" : htmlentities($field->exportValue()) ?>">
	<?php
}

/**
 * @}
 */
?>
