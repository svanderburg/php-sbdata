<?php
namespace Examples\CAPTCHA\View\HTML\Field;
use Examples\CAPTCHA\Model\Field\CAPTCHAField;

function displayCAPTCHAField(CAPTCHAField $field)
{
	// Do nothing
}

function displayEditableCAPTCHAField($name, CAPTCHAField $field)
{
	\SBData\View\HTML\Field\displayEditableRawTextField($name, $field);
	$parsedURL = parse_url($_SESSION['captcha']['image_src']);
	?>
	<img src="<?= $field->baseURL.basename($parsedURL["path"])."?".$parsedURL["query"] ?>" alt="Code"><br>
	<?= $field->instruction ?>
	<?php
}
?>
