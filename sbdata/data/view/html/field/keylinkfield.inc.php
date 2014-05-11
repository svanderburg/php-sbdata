<?php
require_once("hiddenfield.inc.php");

function displayKeyLinkField(KeyLinkField $field)
{
	?>
	<a href="<?php print($field->baseURL.$field->value); ?>"><?php print(htmlentities($field->value)); ?></a>
	<?php
}

function displayEditableKeyLinkField($name, KeyLinkField $field)
{
	?>
	<input type="hidden" name="<?php print($name); ?>" value="<?php print($field->value); ?>">
	<?php
	displayKeyLinKField($field);
}
?>
