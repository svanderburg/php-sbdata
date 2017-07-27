<?php
namespace SBData\View\HTML\Field;
use SBData\Model\Field\HiddenField;

function displayHiddenField($name, HiddenField $field)
{
	?>
	<div style="display: none;"><input name="<?php print($name); ?>" type="hidden" value="<?php print(htmlentities($field->value)); ?>"></div>
	<?php
}
?>
