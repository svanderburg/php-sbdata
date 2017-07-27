<?php
namespace SBData\View\HTML\Field;
use SBData\Model\Field\FileField;

function displayFileField(FileField $field)
{
	displayTextField($field);
}

function displayEditableFileField($name, FileField $field)
{
	?>
	<input name="<?php print($name); ?>" type="file" value="<?php print(htmlentities($field->value)); ?>">
	<?php
}
?>
