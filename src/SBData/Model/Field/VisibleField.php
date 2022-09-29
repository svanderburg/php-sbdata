<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element that may be located
 * inside a form or a table that is visible to the user.
 */
class VisibleField extends Field
{
	/** Title of the field */
	public string $title;

	/**
	 * Constructs a new VisibleField instance.
	 *
	 * @param $title Title of the field
	 * @param $value An object that stores and checks the value of the field
	 */
	public function __construct(string $title, Value $value)
	{
		parent::__construct($value, true);
		$this->title = $title;
	}
}
?>
