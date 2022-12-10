<?php
namespace SBData\View\HTML;

function composeSafeURLToSelf()
{
	return strtok($_SERVER["REQUEST_URI"], '?');
}
?>
