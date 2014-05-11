<?php
function displayArrayComboBoxField(ArrayComboBoxField $field)
{
	foreach($field->values as $key => $value)
	{
		if($key == $field->value)
		{
			print($value);
			break;
		}
	}
}

function displayEditableArrayComboBoxField($name, ArrayComboBoxField $field)
{
	?>
	<select name="<?php print($name); ?>">
		<?php
		foreach($field->values as $key => $value)
		{
			?>
			<option value="<?php print($key); ?>"<?php if($key == $field->value) print(" selected"); ?>><?php print($value); ?></option>
			<?php
		} 
		?>
	</select>
	<?php
}
?>
