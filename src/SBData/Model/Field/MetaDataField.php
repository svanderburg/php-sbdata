<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element that is used as
 * metadata for another field, typically a key link field.
 */
class MetaDataField extends Field
{
	/**
	 * Constructs a new MetaDataField instance
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 */
	public function __construct(bool $mandatory = false, int $maxlength = null)
	{
		parent::__construct(new Value($mandatory, $maxlength));
	}
}
?>
