<?php
require_once("hiddenfield.inc.php");

function displayKeyLinkField(KeyLinkField $field, Form $form)
{
	?>
	<a href="<?php print(($field->composeURLFunction)($field, $form)); ?>"><?php print(htmlentities($field->value)); ?></a>
	<?php
}

function displayEditableKeyLinkField($name, KeyLinkField $field, Form $form)
{
	?>
	<input type="hidden" name="<?php print($name); ?>" value="<?php print($field->value); ?>">
	<?php
	displayKeyLinkField($field, $form);
}
?>
