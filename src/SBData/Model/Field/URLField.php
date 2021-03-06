<?php
namespace SBData\Model\Field;

/**
* Represents the structure of an individual data element containing an URL.
*/
class URLField extends TextField
{
	/**
	 * Constructs a new URLField instance
	 *
	 * @param string $title Title of the field
	 * @param bool $mandatory Indicates whether a given value is mandatory
  	 */
	public function __construct($title, $mandatory = false)
	{
		parent::__construct($title, $mandatory);
	}
	
	/**
	 * @see TextField::checkField()
	 */
	public function checkField($name)
	{
		if(!parent::checkField($name))
			return false;
		else
		{
			if(!$this->mandatory && $this->value === "")
				return true;
			else
				return (filter_var($this->value, FILTER_VALIDATE_URL) !== false);
		}
	}
}
?>
