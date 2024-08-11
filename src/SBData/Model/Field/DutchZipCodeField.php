<?php
namespace SBData\Model\Field;
use SBData\Model\Value\DutchZipCodeValue;

/**
 * Represents the structure of an individual data element containing a Dutch zip code.
 */
class DutchZipCodeField extends GenericTextField
{
	/**
	 * Constructs a new DutchZipCodeField instance
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(string $title, bool $mandatory = false, $defaultValue = null)
	{
		parent::__construct($title, new DutchZipCodeValue($mandatory, $defaultValue), 6);
	}
}
?>
