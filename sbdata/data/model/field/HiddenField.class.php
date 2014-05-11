<?php
require_once("TextField.class.php");

/**
* Represents the structure of an individual data element that is not being displayed and configurable.
*/
class HiddenField extends TextField
{
	/**
  	 * Constructs a new HiddenField instance
	 *
	 * @param bool $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct($mandatory = false)
	{
		parent::__construct("", $mandatory);
	}
}
?>
