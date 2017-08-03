<?php
namespace Examples\CAPTCHA\View\HTML\Field;
use Examples\CAPTCHA\Model\Field\CAPTCHAField;

function displayCAPTCHAField(CAPTCHAField $field)
{
	// Do nothing
}

function displayEditableCAPTCHAField($name, CAPTCHAField $field)
{
	\SBData\View\HTML\Field\displayEditableTextField($name, $field);
	$parsedURL = parse_url($_SESSION['captcha']['image_src']);
	?>
	<img src="<?php print($field->baseURL.basename($parsedURL["path"])."?".$parsedURL["query"]); ?>" alt="Code"><br>
	<?php
	print($field->instruction);
}
?>
