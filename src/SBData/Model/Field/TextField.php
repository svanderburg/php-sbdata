<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element containing arbitrary text.
 */
class TextField extends Field
{
	/** Preferred size of the text field */
	public int $size;
	
	/** Maximum size of the text field or null for infinite size */
	public ?int $maxlength;
	
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
		parent::__construct($title, $mandatory);
		$this->size = $size;
		$this->maxlength = $maxlength;
	}
	
	/**
	 * @see Field::checkField()
	 */
	public function checkField(string $name): bool
	{
		$this->value = trim($this->value); // Trim whitespace that comes in front and after the input
		
		if($this->mandatory && $this->value == "") // Mandatory text fields are not allowed to be empty
			return false;
		
		if($this->maxlength !== null && strlen($this->value) > $this->maxlength) // Text fields cannot exceed their maximum length
			return false;
		
		return true;
	}
}
?>
