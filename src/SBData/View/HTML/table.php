<?php
/**
 * @file
 * @brief View-HTML-Table module
 * @defgroup View-HTML-Table
 * @{
 */
namespace SBData\View\HTML;
use SBData\Model\Form;
use SBData\Model\Table\Table;

function displayTableHeader(Table $table): void
{
	?>
	<tr>
		<?php
		foreach($table->columns as $name => $field)
		{
			if($field->visible)
			{
				?>
				<th><?php print($field->title); ?></th>
				<?php
			}
		}
		?>
	</tr>
	<?php
}

function displayNoItemsLabel(Table $table, string $noItemsLabel, string $anchorPrefix): void
{
	?>
	<tr>
		<td colspan="<?php print($table->computeNumberOfDisplayableColumns()); ?>"><?php if($table->identifyRows) { ?><a name="<?php print($anchorPrefix); ?>-0"></a><?php }; print($noItemsLabel); ?></td>
	</tr>
	<?php
}

function displayFields(Table $table, Form $form, string $anchorPrefix): void
{
	$first = true;

	foreach($form->fields as $name => $field)
	{
		if($field->visible)
		{
			?>
			<td><?php if($table->identifyRows && $first) { ?><a name="<?php print($anchorPrefix."-".$form->fields["__id"]->exportValue()); ?>"></a><?php }; displayField($field, $form); ?></td>
			<?php
		}

		$first = false;
	}
}

/**
 * Displays a table with fields in a non-editable way.
 *
 * @param $table Table to display
 * @param $noItemsLabel Label to be displayed when there are no items in the table
 * @param $anchorPrefix The prefix that the hidden anchor elements should have
 */
function displayTable(Table $table, string $noItemsLabel = "No items", string $anchorPrefix = "table-row"): void
{
	?>
	<div class="tablewrapper">
		<table>
			<?php
			displayTableHeader($table);

			if(($form = $table->nextForm()) === null)
				displayNoItemsLabel($table, $noItemsLabel, $anchorPrefix);
			else
			{
				do
				{
					?>
					<tr>
						<?php displayFields($table, $form, $anchorPrefix); ?>
					</tr>
					<?php
				}
				while(($form = $table->nextForm()) !== null);
			}
			?>
		</table>
	</div>
	<?php
}

function displayActionLink(Form $form, string $actionFunction, string $label): void
{
	$url = $actionFunction($form);

	if($url !== null)
	{
		?>
		<a href="<?php print($url); ?>"><?php print($label); ?></a>
		<?php
	}
}

function displayActionLinks(Table $table, Form $form): void
{
	if($table->actions !== null)
	{
		foreach($table->actions as $label => $actionFunction)
		{
			?>
			<td><?php displayActionLink($form, $actionFunction, $label); ?></td>
			<?php
		}
	}
}

/**
 * Displays a table with fields in a semi-editable way. In this table, fields can
 * not be edited, but there are edit and delete buttons.
 *
 * @param $table Table to display
 * @param $noItemsLabel Label to be displayed when there are no items in the table
 * @param $anchorPrefix The prefix that the hidden anchor elements should have
 */
function displaySemiEditableTable(Table $table, string $noItemsLabel = "No items", string $anchorPrefix = "table-row"): void
{
	?>
	<div class="tablewrapper">
		<table>
			<?php
			displayTableHeader($table);

			if(($form = $table->nextForm()) === null)
				displayNoItemsLabel($table, $noItemsLabel, $anchorPrefix);
			else
			{
				do
				{
					?>
					<tr>
						<?php
						displayFields($table, $form, $anchorPrefix);
						displayActionLinks($table, $form);
						?>
					</tr>
					<?php
				}
				while(($form = $table->nextForm()) !== null);
			}
			?>
		</table>
	</div>
	<?php
}

function displayEditableTableHeader(Table $table): void
{
	?>
	<div class="tr">
		<?php
		foreach($table->columns as $name => $field)
		{
			if($field->visible)
			{
				?>
				<div class="th"><?php print($field->title); displayMandatorySign($field); ?></div>
				<?php
			}
		}
		?>
	</div>
	<?php
}

function displayNoItemsLabelForEditableTable(string $noItemsLabel, string $anchorPrefix): void
{
	?>
	<div class="tr">
		<div class="td"><a name="<?php print($anchorPrefix); ?>-0"></a><?php print($noItemsLabel); ?></div>
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
			<div class="td<?php if(!$field->isValid()) print(" invalid"); ?>"><?php displayEditableField($name, $field, $form); ?></div>
			<?php
		}
		else
			displayEditableField($name, $field, $form);
	}
}

function displayActionLinksForEditableTable(Table $table, Form $form): void
{
	if($table->actions !== null)
	{
		foreach($table->actions as $label => $actionFunction)
		{
			?>
			<div class="td"><?php displayActionLink($form, $actionFunction, $label); ?></div>
			<?php
		}
	}
}

function displayEditButtonForEditableTable(Table $table, Form $form, string $editLabel, string $anchorPrefix): void
{
	?>
	<div class="td"><?php if($table->identifyRows) { ?><a name="<?php print($anchorPrefix."-".$form->fields["__id"]->exportValue()); ?>"><?php } ?><button><?php print($editLabel); ?></button><?php if($table->identifyRows) { ?></a><?php } ?></div>
	<?php
}

/**
 * Displays a table with fields in an editable way. In this table, fields can be directly edited.
 *
 * @param $table Table to display
 * @param $submittedForm Form that contains the last submitted data that has changed, or null if no data was submitted
 * @param $noItemsLabel Label to be displayed when there are no items in the table
 * @param $editLabel Label to be displayed on the edit button
 * @param $anchorPrefix The prefix that the hidden anchor elements should have
 */
function displayEditableTable(Table $table, Form $submittedForm = null, string $noItemsLabel = "No items", string $editLabel = "Edit", string $anchorPrefix = "table-row"): void
{
	?>
	<div class="tablewrapper">
		<div class="table">
			<?php
			displayEditableTableHeader($table);

			/* Display the editable records */

			if(($form = $table->nextForm()) === null)
				displayNoItemsLabelForEditableTable($noItemsLabel, $anchorPrefix);
			else
			{
				do
				{
					/* Compose an encType attribute if the form contains a file field */
					$encTypeAttribute = composeEncTypeAttribute($form);

					$form->checkFields(); // Check field validity

					$rowId = $form->fields["__id"]->exportValue();

					if($submittedForm !== null && !$submittedForm->checkValid() && $submittedForm->fields["__id"]->exportValue() == $rowId)
						$form = $submittedForm; // If a submitted form is given use that}
					?>
					<form class="tr" method="post" action="<?php print($_SERVER["PHP_SELF"]."#".$anchorPrefix."-".$rowId); ?>"<?php print($encTypeAttribute); ?>>
						<?php
						displayEditableFields($form);
						displayEditButtonForEditableTable($table, $form, $editLabel, $anchorPrefix);
						displayActionLinksForEditableTable($table, $form);
						?>
					</form>
					<?php
				}
				while(($form = $table->nextForm()) !== null);
			}
			?>
		</div>
	</div>
	<?php
}

/**
 * @}
 */
?>
