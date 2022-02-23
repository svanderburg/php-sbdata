<?php
/**
 * @file
 * @brief View-HTML-Field-DBComboBoxField module
 * @defgroup View-HTML-Field-DBComboBoxField
 * @{
 */

namespace SBData\View\HTML\Field;
use SBData\Model\Field\ComboBoxField\DBComboBoxField;

function displayDBComboBoxField(DBComboBoxField $field): void
{
	if($value = $field->fetchValue())
		print($value);
}

function displayEditableDBComboBoxField(string $name, DBComboBoxField $field): void
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

/**
 * @}
 */
?>
