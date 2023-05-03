<?php
/**
 * @file
 * @brief View-HTML-Table module
 * @defgroup View-HTML-Table
 * @{
 */
namespace SBData\View\HTML;
use Closure;
use SBData\Model\Form;
use SBData\Model\Table\Action;
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
				<th><?= $field->title ?></th>
				<?php
			}
		}
		?>
	</tr>
	<?php
}

function displayNoItemsLabel(Table $table): void
{
	?>
	<tr>
		<td colspan="<?= $table->computeNumberOfDisplayableColumns() ?>"><?php if($table->identifyRows) { ?><a name="<?= $table->anchorPrefix ?>-0"></a><?php }; print($table->noItemsLabel); ?></td>
	</tr>
	<?php
}

function displayFields(Table $table, Form $form): void
{
	$first = true;

	foreach($form->fields as $name => $field)
	{
		if($field->visible)
		{
			?>
			<td><?php if($table->identifyRows && $first) { ?><a name="<?= $table->anchorPrefix."-".$form->fields["__id"]->exportValue() ?>"></a><?php }; displayField($field, $form); ?></td>
			<?php
		}

		$first = false;
	}
}

/**
 * Displays a table with fields in a non-editable way.
 *
 * @param $table Table to display
 */
function displayTable(Table $table): void
{
	?>
	<div class="tablewrapper">
		<table>
			<?php
			displayTableHeader($table);

			$table->iterator->rewind();

			if($table->iterator->valid())
			{
				do
				{
					$form = $table->iterator->current();

					?>
					<tr>
						<?php displayFields($table, $form); ?>
					</tr>
					<?php
					$table->iterator->next();
				}
				while($table->iterator->valid());
			}
			else
				displayNoItemsLabel($table);
			?>
		</table>
	</div>
	<?php
}

function displayActionLinkLabel(Action $action, string $label): void
{
	if($action->icon === null)
	{
		?><?= $label ?><?php
	}
	else
	{
		?><img src="<?= $action->icon ?>" alt="<?= $label ?>"><?php
	}
}

function displayActionLink(Form $form, Action $action, string $label): void
{
	$url = ($action->generateURLFunction)($form);

	if($url !== null)
	{
		?>
		<a href="<?= $url ?>"><?php displayActionLinkLabel($action, $label); ?></a>
		<?php
	}
}

function displayActionLinks(Table $table, Form $form): void
{
	if($table->actions !== null)
	{
		foreach($table->actions as $label => $action)
		{
			?>
			<td><?php displayActionLink($form, $action, $label); ?></td>
			<?php
		}
	}
}

/**
 * Displays a table with fields in a semi-editable way. In this table, fields can
 * not be edited, but there are edit and delete buttons.
 *
 * @param $table Table to display
 */
function displaySemiEditableTable(Table $table): void
{
	?>
	<div class="tablewrapper">
		<table>
			<?php
			displayTableHeader($table);

			$table->iterator->rewind();

			if($table->iterator->valid())
			{
				do
				{
					$form = $table->iterator->current();
					?>
					<tr>
						<?php
						displayFields($table, $form);
						displayActionLinks($table, $form);
						?>
					</tr>
					<?php
					$table->iterator->next();
				}
				while($table->iterator->valid());
			}
			else
				displayNoItemsLabel($table);
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
				<span class="th"><?= $field->title ?><?php displayMandatorySign($field); ?></span>
				<?php
			}
		}
		?>
	</div>
	<?php
}

function displayNoItemsLabelForEditableTable(Table $table): void
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

function displayActionLinksForEditableTable(Table $table, Form $form): void
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

function displayEditButtonForEditableTable(Table $table, Form $form): void
{
	?>
	<span class="td"><?php if($table->identifyRows) { ?><a name="<?= $table->anchorPrefix."-".$form->fields["__id"]->exportValue() ?>"><?php } ?><button><?php displayLabel($table->saveLabel) ?></button><?php if($table->identifyRows) { ?></a><?php } ?></span>
	<?php
}

/**
 * Displays a table with fields in an editable way. In this table, fields can be directly edited.
 *
 * @param $table Table to display
 * @param $submittedForm Form that contains the last submitted data that has changed, or null if no data was submitted
 */
function displayEditableTable(Table $table, Form $submittedForm = null): void
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

					$rowId = $form->fields["__id"]->exportValue();

					if($submittedForm !== null && !$submittedForm->checkValid() && $submittedForm->fields["__id"]->exportValue() == $rowId)
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
