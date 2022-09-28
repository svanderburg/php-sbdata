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
	<select name="<?php print($name); ?>">
		<?php
		foreach($field->value->values as $key => $value)
		{
			?>
			<option value="<?php print($key); ?>"<?php if($key == $field->exportValue()) print(" selected"); ?>><?php print($value); ?></option>
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
