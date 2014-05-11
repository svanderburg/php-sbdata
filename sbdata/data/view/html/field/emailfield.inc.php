<?php
function displayEmailField(TextField $field)
{
	?>
	<a href="mailto:<?php print($field->value); ?>"><?php print(htmlentities($field->value)); ?></a>
	<?php
}
?>
