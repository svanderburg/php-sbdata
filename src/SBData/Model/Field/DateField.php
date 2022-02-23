<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containing an e-mail address.
 */
class DateField extends TextField
{
	/**
	 * Constructs a new DateField instance
	 *
	 * @param $title Title of the field
	 * @param $defaultToCurrentDate Indicates whether the default value should be set to today
	 * @param $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct(string $title, bool $defaultToCurrentDate = false, bool $mandatory = false)
	{
		parent::__construct($title, $mandatory, 10, 10);
		
		if($defaultToCurrentDate)
			$this->value = date("Y-m-d");
	}
	
	/**
	 * @see TextField::checkField()
	 */
	public function checkField(string $name): bool
	{
		if(!parent::checkField($name))
			return false;

		if(!$this->mandatory && $this->value === "")
			return true;
		else if(preg_match("/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/", $this->value) === 1)
			return checkdate(substr($this->value, 5, 2), substr($this->value, 8, 2), substr($this->value, 0, 4));
		else
			return false;
	}
}
?>
