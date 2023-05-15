<?php
/**
 * @file
 * @brief View-HTML-EditableTable module
 * @defgroup View-HTML-EditableTable
 * @{
 */
namespace SBData\View\HTML;
use SBData\Model\Form;
use SBData\Model\Table\EditableTable;

function displayEditableTableHeader(EditableTable $table): void
{
	?>
	<div class="tr">
		<?php
		foreach($table->columns as $name => $field)
		{
			if($field->visible)
			{
				?>
				<span class="th"><?= $field->title ?><?php displayMandatorySign($field); ?></span>
				<?php
			}
		}
		?>
	</div>
	<?php
}

function displayNoItemsLabelForEditableTable(EditableTable $table): void
{
	?>
	<div class="tr">
		<span class="td"><a name="<?= $table->anchorPrefix ?>-0"></a><?= $table->noItemsLabel ?></span>
	</div>
	<?php
}

function displayEditableFields(Form $form): void
{
	foreach($form->fields as $name => $field)
	{
		if($field->visible)
		{
			?>
			<span class="td<?php if(!$field->isValid()) print(" invalid"); ?>"><?php displayEditableField($name, $field, $form); ?></span>
			<?php
		}
		else
			displayEditableFieldRow($name, true, $field, $form);
	}
}

function displayActionLinksForEditableTable(EditableTable $table, Form $form): void
{
	if($table->actions !== null)
	{
		foreach($table->actions as $label => $action)
		{
			?>
			<span class="td"><?php displayActionLink($form, $action, $label); ?></span>
			<?php
		}
	}
}

function displayEditButtonForEditableTable(EditableTable $table, Form $form): void
{
	?>
	<span class="td"><?php if($table->identifyRows) { ?><a name="<?= $table->anchorPrefix."-".$form->fields[$table->idColumnName]->exportValue() ?>"><?php } ?><button><?php displayLabel($table->saveLabel) ?></button><?php if($table->identifyRows) { ?></a><?php } ?></span>
	<?php
}

/**
 * Displays a table with fields in an editable way. In this table, fields can be directly edited.
 *
 * @param $table Editable table to display
 * @param $submittedForm Form that contains the last submitted data that has changed, or null if no data was submitted
 */
function displayEditableTable(EditableTable $table, Form $submittedForm = null): void
{
	?>
	<div class="tablewrapper">
		<div class="table">
			<?php
			displayEditableTableHeader($table);

			/* Display the editable records */

			$table->iterator->rewind();

			if($table->iterator->valid())
			{
				do
				{
					$form = $table->iterator->current();

					/* Compose an encType attribute if the form contains a file field */
					$encTypeAttribute = composeEncTypeAttribute($form);

					$form->checkFields(); // Check field validity

					$rowId = $form->fields[$table->idColumnName]->exportValue();

					if($submittedForm !== null && !$submittedForm->checkValid() && $submittedForm->fields[$table->idColumnName]->exportValue() == $rowId)
						$form = $submittedForm; // If a submitted form is given use that
					?>
					<form class="tbody" method="post" action="<?= htmlspecialchars($form->actionURL === null ? composeSafeURLToSelf() : $form->actionURL)."#".$table->anchorPrefix."-".$rowId ?>"<?= $encTypeAttribute ?>>
						<div class="tr">
							<?php
							displayEditableFields($form);
							displayEditButtonForEditableTable($table, $form);
							displayActionLinksForEditableTable($table, $form);
							?>
						</div>
					</form>
					<?php
					$table->iterator->next();
				}
				while($table->iterator->valid());
			}
			else
				displayNoItemsLabelForEditableTable($table);
			?>
		</div>
	</div>
	<?php
}

/**
 * @}
 */
?>
