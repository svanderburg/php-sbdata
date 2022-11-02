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
	$stmt = ($field->queryValueFunction)($field->dbh, $field->exportValue());

	if(($value = $field->fetchValue($stmt)) !== null)
		print($value);
}

function displayEditableDBComboBoxField(string $name, DBComboBoxField $field): void
{
	$stmt = ($field->queryOptionsFunction)($field->dbh);

	?>
	<select name="<?= $name ?>">
		<option value="">---</option>
		<?php
		while(($row = $field->fetchOption($stmt)) !== null)
		{
			?>
			<option value="<?= $row["key"] ?>"<?php if($row["key"] == $field->exportValue()) print(" selected"); ?>><?= $row["value"] ?></option>
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
