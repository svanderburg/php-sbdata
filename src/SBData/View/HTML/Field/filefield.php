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
	print(htmlentities($field->exportValue()));
}

function displayEditableFileField(string $name, FileField $field): void
{
	?>
	<input name="<?= $name ?>" type="file" value="<?= htmlentities($field->exportValue()) ?>">
	<?php
}

/**
 * @}
 */
?>
