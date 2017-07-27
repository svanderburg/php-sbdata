<?php
namespace SBData\View\HTML;
use SBData\Model\Form;
use SBData\Model\Field\Field;
use SBData\Model\Field\HiddenField;
use SBData\Model\Field\MetaDataField;

function displayForm(Form $form)
{
	?>
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
	<?php
}

function composeEncTypeAttribute(Form $form)
{
	if($form->hasFileField())
		return ' enctype="multipart/form-data"';
	else
		return "";
}

function displayMandatorySign(Field $field)
{
	if($field->mandatory)
		print('<span class="mandatory">*</span>');
}

function displayEditableForm(Form $form, $submitLabel, $generalErrorMessage, $fieldErrorMessage)
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
	<form method="post" action="<?php print(htmlspecialchars($_SERVER["PHP_SELF"])); ?>"<?php print(composeEncTypeAttribute($form)); ?>>
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
	<?php
}
