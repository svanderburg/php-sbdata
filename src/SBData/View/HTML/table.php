<?php
/**
 * @file
 * @brief View-HTML-Table module
 * @defgroup View-HTML-Table
 * @{
 */
namespace SBData\View\HTML;
use SBData\Model\Form;
use SBData\Model\Field\HiddenField;
use SBData\Model\Field\MetaDataField;
use SBData\Model\Table\Table;

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

function displayTableHeader(Table $table): void
{
	?>
	<tr>
		<?php
		foreach($table->columns as $name => $field)
		{
			if(!$field instanceof HiddenField && !$field instanceof MetaDataField)
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

function displayNoItemsLabel(Table $table, string $noItemsLabel, bool $displayAnchors, string $anchorPrefix): void
{
	?>
	<tr>
		<td colspan="<?php print($table->computeNumberOfDisplayableColumns()); ?>"><?php if($displayAnchors) { ?><a name="<?php print($anchorPrefix); ?>-0"></a><?php }; print($noItemsLabel); ?></td>
	</tr>
	<?php
}

function displayFields(Form $form, bool $displayAnchors, int $count, string $anchorPrefix): void
{
	$form->fields["__id"]->value = $count;
	$first = true;

	foreach($form->fields as $name => $field)
	{
		if(!$field instanceof HiddenField && !$field instanceof MetaDataField)
		{
			?>
			<td><?php if($displayAnchors && $first) { ?><a name="<?php print($anchorPrefix."-".$count); ?>"></a><?php }; displayField($field, $form); ?></td>
			<?php
		}

		$first = false;
	}
}

/**
 * Displays a table with field in a non-editable way.
 *
 * @param $table Table to display
 * @param $displayAnchors Whether hidden anchors should be displayed that enable searching for specific rows
 * @param $noItemsLabel Label to be displayed when there are no items in the table
 * @param $anchorPrefix The prefix that the hidden anchor elements should have
 */
function displayTable(Table $table, bool $displayAnchors = false, string $noItemsLabel = "No items", string $anchorPrefix = "table-row"): void
{
	?>
	<div class="tablewrapper">
		<table>
			<?php
			displayTableHeader($table);

			if($table->computeNumberOfRows() === 0)
				displayNoItemsLabel($table, $noItemsLabel, $displayAnchors, $anchorPrefix);
			else
			{
				$count = 0;

				while(($form = $table->fetchForm()) !== null)
				{
					?>
					<tr>
						<?php displayFields($form, $displayAnchors, $count, $anchorPrefix); ?>
					</tr>
					<?php
					$count++;
				}
			}
			?>
		</table>
	</div>
	<?php
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
 * Displays a table with field in a semi-editable way. In this table fields can
 * not be edited, but there are edit and delete buttons.
 *
 * @param $table Table to display
 * @param $displayAnchors Whether hidden anchors should be displayed that enable searching for specific rows
 * @param $noItemsLabel Label to be displayed when there are no items in the table
 * @param $anchorPrefix The prefix that the hidden anchor elements should have
 */
function displaySemiEditableTable(Table $table, bool $displayAnchors = false, string $noItemsLabel = "No items", string $anchorPrefix = "table-row"): void
{
	?>
	<div class="tablewrapper">
		<table>
			<?php
			displayTableHeader($table);

			if($table->computeNumberOfRows() === 0)
				displayNoItemsLabel($table, $noItemsLabel, $displayAnchors, $anchorPrefix);
			else
			{
				$count = 0;

				while(($form = $table->fetchForm()) !== null)
				{
					?>
					<tr>
						<?php
						displayFields($form, $displayAnchors, $count, $anchorPrefix);
						displayActionLinks($table, $form);
						?>
					</tr>
					<?php
					$count++;
				}
			}
			?>
		</table>
	</div>
	<?php
}

/**
 * Displays a table with field in an editable way. In this table fields can be directly edited.
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
			<div class="tr">
				<?php
				/* Display table header */

				foreach($table->columns as $name => $field)
				{
					if(!$field instanceof HiddenField && !$field instanceof MetaDataField)
					{
						?>
						<div class="th"><?php print($field->title); displayMandatorySign($field); ?></div>
						<?php
					}
				}
				?>
			</div>
			<?php
			/* Display the editable records */

			if($table->computeNumberOfRows() === 0)
			{
				?>
				<div class="tr">
					<div class="td"><a name="<?php print($anchorPrefix); ?>-0"></a><?php print($noItemsLabel); ?></div>
				</div>
				<?php
			}
			else
			{
				$count = 0;

				while($form = $table->fetchForm())
				{
					/* Compose an encType attribute if the form contains a file field */
					$encTypeAttribute = composeEncTypeAttribute($form);

					$form->checkFields(); // Check field validity

					if($submittedForm !== null && $submittedForm->fields["__id"]->value == $count && !$submittedForm->checkValid())
						$form = $submittedForm; // If a submitted form is given use that
					else
						$form->fields["__id"]->value = $count; // Otherwise, use the generated one and add the row id value to it
					?>
					<form class="tr" method="post" action="<?php print($_SERVER["PHP_SELF"]."#".$anchorPrefix."-".$count); ?>"<?php print($encTypeAttribute); ?>>
						<?php
						foreach($form->fields as $name => $field)
						{
							if($field instanceof HiddenField)
								\SBData\View\HTML\Field\displayHiddenField($name, $field);
							else if(!$field instanceof MetaDataField)
							{
								?>
								<div class="td<?php if(!$field->valid) print(" invalid"); ?>"><?php displayEditableField($name, $field, $form); ?></div>
								<?php
							}
						}
						?>
						<div class="td"><a name="<?php print($anchorPrefix."-".$count); ?>"><button><?php print($editLabel); ?></button></a></div>
						<?php
						if($table->actions !== null)
						{
							foreach($table->actions as $label => $actionFunction)
							{
								?>
								<div class="td"><?php displayActionLink($form, $actionFunction, $label); ?></div>
								<?php
							}
						}
						?>
					</form>
					<?php
					$count++;
				}
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
