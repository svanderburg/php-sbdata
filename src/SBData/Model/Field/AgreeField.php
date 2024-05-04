<?php
namespace SBData\Model\Field;
use SBData\Model\Value\TrueValue;

/**
 * Represents the structure of an individual data element containing a checked box that must be enabled to become valid.
 */
class AgreeField extends VisibleField
{
	/**
	 * Constructs a new CheckBoxField instance.
	 *
	 * @param $title Title of the field
	 * @param $checkedValue Value that will be set if the checkbox has been checked
	 */
	public function __construct(string $title, string $checkedValue = "1")
	{
		parent::__construct($title, new TrueValue($checkedValue, null));
	}
}
?>
