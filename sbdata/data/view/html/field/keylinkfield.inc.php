<?php
require_once("hiddenfield.inc.php");

function displayKeyLinkField(KeyLinkField $field, Form $form)
{
	$composeURLFunction = $field->composeURLFunction;
	$linkURL = $composeURLFunction($field, $form);

	if($linkURL === null)
		print(htmlentities($field->value));
	else
	{
		?>
		<a href="<?php print($linkURL); ?>"><?php print(htmlentities($field->value)); ?></a>
		<?php
	}
}

function displayEditableKeyLinkField($name, KeyLinkField $field, Form $form)
{
	?>
	<input type="hidden" name="<?php print($name); ?>" value="<?php print(htmlentities($field->value)); ?>">
	<?php
	displayKeyLinkField($field, $form);
}
?>
