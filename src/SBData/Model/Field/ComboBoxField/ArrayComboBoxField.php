<?php
namespace SBData\Model\Field\ComboBoxField;
use SBData\Model\Field\TextField;

/**
 * Represents the structure of an individual data element that should be displayed as a combo box
 * which data is retrieved from an array of objects.
 */
class ArrayComboBoxField extends TextField
{
	/** An associative array which key represents to the option value and the value to the text being displayed */ 
	public array $values;
	
	/**
	 * Constructs a new ArrayComboBoxField instance.
	 * 
	 * @param $title Title of the field
	 * @param $values An array in which the keys correspond to the input names and values to their descriptions
	 * @param $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct(string $title, array $values, bool $mandatory = false)
	{
		parent::__construct($title, $mandatory);
		$this->values = $values;
	}
	
	/**
	 * @see TextField::checkField()
	 */
	public function checkField(string $name): bool
	{
		if(!$this->mandatory && $this->value == "")
			return true;
		else
			return array_key_exists($this->value, $this->values);
	}
}
?>
