<?php
namespace SBData\Model\Value;

/**
 * Stores a value and checks whether it is a valid natural number.
 */
class NaturalNumberValue extends IntegerValue
{
	/**
	 * @see IntegerValue::__construct()
	 */
	public function __construct(bool $mandatory = false, int $maxlength = null, $defaultValue = null, int $maxValue = null)
	{
		parent::__construct($mandatory, $maxlength, $defaultValue, 0, null);
	}
}
?>
