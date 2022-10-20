<?php
namespace SBData\Model\Field;
use SBData\Model\Value\ISODateValue;

/**
 * Represents the structure of an individual data element containing an e-mail address.
 */
class DateField extends GenericTextField
{
	/**
	 * Constructs a new DateField instance
	 *
	 * @param $title Title of the field
	 * @param $defaultToCurrentDate Indicates whether the default value should be set to today
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(string $title, bool $defaultToCurrentDate = false, bool $mandatory = false, $defaultValue = null)
	{
		parent::__construct($title, new ISODateValue($defaultToCurrentDate, $mandatory, $defaultValue), 10);
	}
}
?>
