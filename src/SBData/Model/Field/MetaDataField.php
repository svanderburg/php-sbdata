<?php
namespace SBData\Model\Field;

/**
 * Represents the structure of an individual data element that is used as
 * metadata for another field, typically a key link field.
 */
class MetaDataField extends TextField
{
	/**
	 * Constructs a new MetaDataField instance
	 *
	 * @param bool $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct($mandatory = false)
	{
		parent::__construct("", $mandatory);
	}
}
?>
