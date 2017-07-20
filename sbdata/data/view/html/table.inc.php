<?php
require_once("field/hiddenfield.inc.php");
require_once("field/textfield.inc.php");
require_once("field/urlfield.inc.php");
require_once("field/emailfield.inc.php");
require_once("field/keylinkfield.inc.php");
require_once("form.inc.php");

function displayActionLink(Form $form, $actionFunction, $label)
{
	$url = $actionFunction($form);

	if($url !== null)
	{
		?>
		<a href="<?php print($url); ?>"><?php print($label); ?></a>
		<?php
	}
}

function displayTableHeader(Table $table)
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

function displayNoItemsLabel(Table $table, $noItemsLabel)
{
	?>
	<tr>
		<td colspan="<?php print($table->computeNumberOfDisplayableColumns()); ?>"><?php print($noItemsLabel); ?></td>
	</tr>
	<?php
}

function displayFields(Form $form)
{
	foreach($form->fields as $name => $field)
	{
		if(!$field instanceof HiddenField && !$field instanceof MetaDataField)
		{
			?>
			<td><?php displayField($field, $form); ?></td>
			<?php
		}
	}
}

function displayTable(Table $table, $noItemsLabel = "No items")
{
	?>
	<table>
		<?php
		displayTableHeader($table);

		if($table->computeNumberOfRows() === 0)
			displayNoItemsLabel($table, $noItemsLabel);
		else
		{
			while(($form = $table->fetchForm()) !== null)
			{
				?>
				<tr>
					<?php displayFields($form); ?>
				</tr>
				<?php
			}
		}
		?>
	</table>
	<?php
}

function displayActionLinks(Table $table, Form $form)
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

function displaySemiEditableTable(Table $table, $noItemsLabel = "No items")
{
	?>
	<table>
		<?php
		displayTableHeader($table);

		if($table->computeNumberOfRows() === 0)
			displayNoItemsLabel($table, $noItemsLabel);
		else
		{
			while(($form = $table->fetchForm()) !== null)
			{
				?>
				<tr>
					<?php
					displayFields($form);
					displayActionLinks($table, $form);
					?>
				</tr>
				<?php
			}
		}
		?>
	</table>
	<?php
}

function displayEditableTable(Table $table, Form $submittedForm = null, $noItemsLabel = "No items", $editLabel = "Edit")
{
	?>
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
				<div class="td"><?php print($noItemsLabel); ?></div>
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
				<form class="tr" method="post" action="<?php print($_SERVER["PHP_SELF"]); ?>#table-row-<?php print($count); ?>"<?php print($encTypeAttribute); ?>>
					<?php
					foreach($form->fields as $name => $field)
					{
						if($field instanceof HiddenField)
							displayHiddenField($name, $field);
						else if(!$field instanceof MetaDataField)
						{
							?>
							<div class="td<?php if(!$field->valid) print(" invalid"); ?>"><?php displayEditableField($name, $field, $form); ?></div>
							<?php
						}
					}
					?>
					<div class="td"><a name="table-row-<?php print($count); ?>"><button><?php print($editLabel); ?></button></a></div>
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
	<?php
}
?>
