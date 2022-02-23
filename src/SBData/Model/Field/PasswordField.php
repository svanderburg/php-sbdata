<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containing a password.
 */
class PasswordField extends TextField
{
	/**
	 * Constructs a new TextField instance
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $size Preferred size of the text field
	 * @param $maxlength Maximum size of the text field or null for infinity size
	 */
	public function __construct(string $title, bool $mandatory = false, int $size = 20, ?int $maxlength = null)
	{
		parent::__construct($title, $mandatory, $size, $maxlength);
	}
	
	/**
	 * @see Field::checkField()
	 */
	public function checkField(string $name): bool
	{
		if($this->mandatory && $this->value == "") // Mandatory text fields are not allowed to be empty
			return false;
		
		if($this->maxlength !== null && strlen($this->value) > $this->maxlength) // Text fields cannot exceed their maximum length
			return false;
		
		return true;
	}
}
?>
