<?php
require_once("TextField.class.php");

/**
 * Represents the structure of an individual data element containing linking to another page.
 */
class KeyLinkField extends TextField
{
	/** Base URL of the link */
	public $baseURL;
	
	/**
	 * Constructs a new KeyLinkField instance
	 * 
	 * @param string $title Title of the field
	 * @param string $baseURL Base URL of the link
	 * @param bool $mandatory Indicates whether a given value is mandatory
	 * @param int $size Preferred size of the text field
	 * @param int $maxlength Maximum size of the text field or null for infinity size
	 */
	public function __construct($title, $baseURL, $mandatory = false, $size = 20, $maxlength = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength);
		$this->baseURL = $baseURL;
	}
}
?>
