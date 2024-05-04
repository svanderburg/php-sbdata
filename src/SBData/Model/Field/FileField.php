<?php
namespace SBData\Model\Field;
use SBData\Model\Value\FileValue;

/**
 * Represents the structure of an individual data element containing a file reference.
 */
class FileField extends VisibleField
{
	/** Required MIME type for the file */
	public string|array|null $mimeType;

	/**
	 * Constructs a new FileField instance.
	 *
	 * @param $title Title of the field
	 * @param $mimeType Required MIME type for the file
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 */
	public function __construct(string $title, string|array|null $mimeType, bool $mandatory = false, int $maxlength = null)
	{
		parent::__construct($title, new FileValue($mimeType, $mandatory, $maxlength));
		$this->mimeType = $mimeType;
	}
}
?>
