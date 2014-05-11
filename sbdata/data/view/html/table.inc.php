<?php
require_once("field/hiddenfield.inc.php");
require_once("field/textfield.inc.php");
require_once("field/urlfield.inc.php");
require_once("field/emailfield.inc.php");
require_once("field/keylinkfield.inc.php");
require_once("form.inc.php");

function displayDeleteLink(Form $form, $deleteFun, $deleteLabel)
{
	?>
	<a href="<?php print($deleteFun($form)); ?>"><?php print($deleteLabel); ?></a>
	<?php
}

function displayTable(Table $table, $deleteFun = null, $deleteLabel = "Delete")
{
	?>
	<table>
		<tr>
			<?php
			/* Display table header */
			
			foreach($table->columns as $name => $field)
			{
				if(!$field instanceof HiddenField)
				{
					?>
					<th><?php print($field->title); ?></th>
					<?php
				}
			}
			?>
		</tr>
		<?php
		/* Display the records */
		while($form = $table->fetchForm())
		{
			?>
			<tr>
				<?php
				foreach($form->fields as $name => $field)
				{
					if(!$field instanceof HiddenField)
					{
						?>
						<td><?php displayField($field); ?></td>
						<?php
					}
				} 
				
				if($deleteFun !== null)
				{
					?>
					<td><?php displayDeleteLink($form, $deleteFun, $deleteLabel); ?></td>
					<?php
				}
				?>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
}

function displayEditableTable(Table $table, Form $submittedForm = null, $deleteFun, $editLabel = "Edit", $deleteLabel = "Delete")
{
	?>
	<div class="table">
		<div class="tr">
			<?php
			/* Display table header */
			
			foreach($table->columns as $name => $field)
			{
				if(!$field instanceof HiddenField)
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
					else
					{
						?>
						<div class="td<?php if(!$field->valid) print(" invalid"); ?>"><?php displayEditableField($name, $field); ?></div>
						<?php
					}
				}
				?>
				<div class="td"><a name="table-row-<?php print($count); ?>"><button><?php print($editLabel); ?></button></a></div>
				<div class="td"><?php displayDeleteLink($form, $deleteFun, $deleteLabel); ?></div>		
			</form>
			<?php
			$count++;
		}
		?>
	</div>
	<?php
}
?>
