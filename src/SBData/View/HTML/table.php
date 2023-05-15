<?php
/**
 * @file
 * @brief View-HTML-Table module
 * @defgroup View-HTML-Table
 * @{
 */
namespace SBData\View\HTML;
use Closure;
use SBData\Model\ReadOnlyForm;
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

function displayFields(Table $table, ReadOnlyForm $form): void
{
	$first = true;

	foreach($form->fields as $name => $field)
	{
		if($field->visible)
		{
			?>
			<td><?php if($table->identifyRows && $first) { ?><a name="<?= $table->anchorPrefix."-".$form->fields[$table->idColumnName]->exportValue() ?>"></a><?php }; displayField($field, $form); ?></td>
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

function displayActionLink(ReadOnlyForm $form, Action $action, string $label): void
{
	$url = ($action->generateURLFunction)($form);

	if($url !== null)
	{
		?>
		<a href="<?= $url ?>"><?php displayActionLinkLabel($action, $label); ?></a>
		<?php
	}
}

function displayActionLinks(Table $table, ReadOnlyForm $form): void
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

/**
 * @}
 */
?>
