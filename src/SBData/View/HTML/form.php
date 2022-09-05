<?php
/**
 * @file
 * @brief View-HTML-Form module
 * @defgroup View-HTML-Form
 * @{
 */
namespace SBData\View\HTML;
use SBData\Model\Form;
use SBData\Model\Field\Field;
use SBData\Model\Field\HiddenField;
use SBData\Model\Field\MetaDataField;

/**
 * Displays a form with fields in a non-editable way.
 *
 * @param $form Form to display
 */
function displayForm(Form $form): void
{
	?>
	<div class="formwrapper">
		<table>
			<?php
			foreach($form->fields as $name => $field)
			{
				if(!$field instanceof HiddenField && !$field instanceof MetaDataField)
				{
					?>
					<tr>
						<th><?php print($field->title); ?></th>
						<td><?php displayField($field, $form); ?></td>
					</tr>
					<?php
				}
			}
			?>
		</table>
	</div>
	<?php
}

function composeEncTypeAttribute(Form $form): string
{
	if($form->hasFileField())
		return ' enctype="multipart/form-data"';
	else
		return "";
}

function displayMandatorySign(Field $field): void
{
	if($field->mandatory)
		print('<span class="mandatory">*</span>');
}

/**
 * Displays a form with fields in an editable way.
 *
 * @param $form Form to display
 * @param $submitLabel Label to be displayed on the submit button
 * @param $generalErrorMessage General error message displayed when a field is invalid
 * @param $fieldErrorMessage Error message displayed for an invalid field
 */
function displayEditableForm(Form $form, string $submitLabel, string $generalErrorMessage, string $fieldErrorMessage): void
{
	/* If the form is invalid state display the general error message */
	
	if(!$form->checkValid())
	{
		?>
		<p><?php print($generalErrorMessage); ?></p>
		<?php
	}
	
	/* Display the form */
	?>
	<div class="formwrapper">
		<form method="post" action="<?php print(htmlspecialchars($form->actionURL === null ? $_SERVER["PHP_SELF"] : $form->actionURL)); ?>"<?php print(composeEncTypeAttribute($form)); ?>>
			<?php
			/* Display each field */
			foreach($form->fields as $name => $field)
			{
				if($field instanceof HiddenField)
					\SBData\View\HTML\Field\displayHiddenField($name, $field);
				else if(!$field instanceof MetaDataField)
				{
					?>
					<div>
						<label><?php print($field->title); displayMandatorySign($field); ?></label>
						<?php
						displayEditableField($name, $field, $form);

						/* If field is invalid, display a description */
						if(!$field->valid)
						{
							?>
							<br><span class="mandatory"><?php print($fieldErrorMessage); ?></span>
							<?php
						}
						?>
					</div>
					<?php
				}
			}
			?>
			<p><button><?php print($submitLabel); ?></button></p>
		</form>
	</div>
	<?php
}

/**
 * @}
 */
?>
