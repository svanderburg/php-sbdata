<?php
/**
 * @file
 * @brief View-HTML-Field-KeyLinkField module
 * @defgroup View-HTML-Field-KeyLinkField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Form;
use SBData\Model\Field\KeyLinkField;

function displayKeyLinkField(KeyLinkField $field, Form $form): void
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

function displayEditableKeyLinkField(string $name, KeyLinkField $field, Form $form): void
{
	?>
	<input type="hidden" name="<?php print($name); ?>" value="<?php print(htmlentities($field->value)); ?>">
	<?php
	displayKeyLinkField($field, $form);
}

/**
 * @}
 */
?>
