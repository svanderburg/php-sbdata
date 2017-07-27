<?php
namespace SBData\View\HTML\Field;
use SBData\Model\Field\URLField;

function displayURLField(URLField $field)
{
	if($field->value !== "")
	{
		?>
		<a href="<?php print($field->value); ?>"><?php print(htmlentities($field->value)); ?></a>
		<?php
	}
}

function displayEditableURLField($name, URLField $field)
{
	displayEditableTextField($name, $field);
}
?>
