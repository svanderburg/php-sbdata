<?php
namespace SBData\View\HTML\Field;
use SBData\Model\Field\PasswordField;

function displayPasswordField(PasswordField $field)
{
	// Never display a password
}

function displayEditablePasswordField($name, PasswordField $field)
{
	?>
	<input name="<?php print($name); ?>" type="password" size="<?php print($field->size); ?>"<?php if($field->maxlength !== null) print(' maxlength="'.$field->maxlength.'"'); ?>>
	<?php
}
?>
