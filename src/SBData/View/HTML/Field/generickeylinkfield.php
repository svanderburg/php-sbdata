<?php
/**
 * @file
 * @brief View-HTML-Field-GenericKeyLinkField module
 * @defgroup View-HTML-Field-GenericKeyLinkField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Form;
use SBData\Model\Field\GenericKeyLinkField;

function displayGenericKeyLinkField(GenericKeyLinkField $field, Form $form): void
{
	$composeURLFunction = $field->composeURLFunction;
	$linkURL = $composeURLFunction($field, $form);
	$value = $field->exportValue();

	if($linkURL === null)
		print(htmlentities($value));
	else
	{
		?>
		<a href="<?= $linkURL ?>"><?= htmlentities($value) ?></a>
		<?php
	}
}

function displayEditableGenericKeyLinkField(string $name, GenericKeyLinkField $field, Form $form): void
{
	?>
	<input type="hidden" name="<?= $name ?>" value="<?= htmlentities($field->exportValue()) ?>">
	<?php
	displayGenericKeyLinkField($field, $form);
}

/**
 * @}
 */
?>
