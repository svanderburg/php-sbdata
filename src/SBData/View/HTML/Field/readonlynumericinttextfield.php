<?php
namespace SBData\View\HTML\Field;
use SBData\Model\Field\ReadOnlyNumericIntTextField;

function displayReadOnlyNumericIntTextField(ReadOnlyNumericIntTextField $field)
{
	displayTextField($field);
}

function displayEditableReadOnlyNumericIntTextField($name, ReadOnlyNumericIntTextField $field)
{
	?>
	<input name="<?php print($name); ?>" type="text" value="<?php print(htmlentities($field->value)); ?>" size="<?php print($field->size); ?>"<?php if($field->maxlength !== null) print(' maxlength="'.$field->maxlength.'"'); ?> readonly>
	<?php
}
?>
