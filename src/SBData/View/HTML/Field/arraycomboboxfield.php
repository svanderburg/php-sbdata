<?php
/**
 * @file
 * @brief View-HTML-Field-ArrayComboBoxField module
 * @defgroup View-HTML-Field-ArrayComboBoxField
 * @{
 */
namespace SBData\View\HTML\Field;
use SBData\Model\Field\ComboBoxField\ArrayComboBoxField;

function displayArrayComboBoxField(ArrayComboBoxField $field): void
{
	foreach($field->value->values as $key => $value)
	{
		if($key == $field->exportValue())
		{
			print($value);
			break;
		}
	}
}

function displayEditableArrayComboBoxField(string $name, ArrayComboBoxField $field): void
{
	?>
	<select name="<?= $name ?>">
		<?php
		foreach($field->value->values as $key => $value)
		{
			?>
			<option value="<?= $key ?>"<?php if($key == $field->exportValue()) print(" selected"); ?>><?= $value ?></option>
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
