<?php
function displayHiddenField($name, HiddenField $field)
{
	?>
	<div style="display: none;"><input name="<?php print($name); ?>" type="hidden" value="<?php print(htmlentities($field->value)); ?>"></div>
	<?php
}
?>
