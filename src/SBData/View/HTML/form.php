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
				if($field->visible)
				{
					?>
					<tr>
						<th><?= $field->title ?></th>
						<td><?= displayField($field, $form) ?></td>
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
	if($field->value->mandatory)
		print('<span class="mandatory">*</span>');
}

/**
 * Displays a form with fields in an editable way.
 *
 * @param $form Form to display
 */
function displayEditableForm(Form $form): void
{
	/* If the form is invalid state display the general error message */
	
	if(!$form->checkValid())
	{
		?>
		<p><?= $form->validationErrorMessage ?></p>
		<?php
	}
	
	/* Display the form */
	?>
	<div class="formwrapper">
		<form method="post" action="<?= htmlspecialchars($form->actionURL === null ? composeSafeURLToSelf() : $form->actionURL) ?>"<?= composeEncTypeAttribute($form) ?>>
			<?php
			/* Display each field */
			foreach($form->fields as $name => $field)
			{
				if($field->visible)
				{
					?>
					<div>
						<label><?= $field->title ?><?php displayMandatorySign($field); ?></label>
						<?php
						displayEditableField($name, $field, $form);

						/* If field is invalid, display a description */
						if(!$field->isValid())
						{
							?>
							<br><span class="mandatory"><?= $form->fieldErrorMessage ?></span>
							<?php
						}
						?>
					</div>
					<?php
				}
				else
					displayEditableFieldRow($name, false, $field, $form);
			}
			?>
			<div><button><?php displayLabel($form->submitLabel); ?></button></div>
		</form>
	</div>
	<?php
}

/**
 * @}
 */
?>
