<?php
/**
 * @file
 * @brief View-HTML-Label module
 * @defgroup View-HTML-Label
 * @{
 */
namespace SBData\View\HTML;
use SBData\Model\Label\Label;
use SBData\Model\Label\IconLabel;
use SBData\Model\Label\IconWithTextLabel;
use SBData\Model\Label\TextLabel;

function displayLabel(Label $label): void
{
	if($label instanceof IconWithTextLabel)
	{
		?><img src="<?= $label->icon ?>" alt="<?= $label->text ?>"> <?= $label->text ?><?php
	}
	else if($label instanceof IconLabel)
	{
		?><img src="<?= $label->icon ?>" alt="<?= $label->text ?>"><?php
	}
	else if($label instanceof TextLabel)
	{
		?><?= $label->text ?><?php
	}
}

/**
 * @}
 */
?>
