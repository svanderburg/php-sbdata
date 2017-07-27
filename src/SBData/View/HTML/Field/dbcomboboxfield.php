<?php
namespace SBData\View\HTML\Field;
use SBData\Model\Field\ComboBoxField\DBComboBoxField;

function displayDBComboBoxField(DBComboBoxField $field)
{
	if($value = $field->fetchValue())
		print($value);
}

function displayEditableDBComboBoxField($name, DBComboBoxField $field)
{	
	?>
	<select name="<?php print($name); ?>">
		<option value="">---</option>
		<?php
		while($row = $field->fetchOption())
		{
			?>
			<option value="<?php print($row["key"]); ?>"<?php if($row["key"] == $field->value) print(" selected"); ?>><?php print($row["value"]); ?></option>
			<?php
		}
		?>
	</select>
	<?php
}
?>
