<?php
function displayURLField(TextField $field)
{
	?>
	<a href="<?php print($field->value); ?>"><?php print(htmlentities($field->value)); ?></a>
	<?php
}
?>
