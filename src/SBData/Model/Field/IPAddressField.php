<?php
namespace SBData\Model\Field;
use SBData\Model\Value\IPAddressValue;

/**
* Represents the structure of an individual data element containing an IPv4 or IPv6 address
*/
class IPAddressField extends GenericTextField
{
	/**
	 * Constructs a new IPAddressField instance.
	 *
	 * @param $title Title of the field
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $flags Properties that need to be checked for (defaults to any valid IPv4 and IPv6 address)
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(string $title, bool $mandatory = false, int $flags = IPAddressValue::FLAG_DEFAULT, $defaultValue = null)
	{
		$value = new IPAddressValue($mandatory, $flags, $defaultValue);
		parent::__construct($title, $value, $value->maxlength);
	}
}
?>
