<?php
namespace SBData\Model\Value;

/**
 * Stores a file path and checks whether a file has been uploaded and (optionally) is of the right MIME type.
 */
class FileValue extends Value
{
	/** Required MIME type for the file or NULL if there is no MIME type requirement */
	public string|array|null $mimeType;

	/**
	 * Constructs a new FileValue instance.
	 *
	 * @param $mimeType Required MIME type for the file or NULL if there is no MIME type requirement
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 */
	public function __construct(string|array|null $mimeType, bool $mandatory = false, int $maxlength = null)
	{
		parent::__construct($mandatory, $maxlength);
		$this->mimeType = $mimeType;
	}

	/**
	 * @see Value::checkValue()
	 */
	public function checkValue(string $name): bool
	{
		if(!$this->mandatory && (!array_key_exists($name, $_FILES) || !array_key_exists("tmp_name", $_FILES[$name]) || $_FILES[$name]["tmp_name"] === "")) // If a file is not mandatory and no file has been provided then everything is ok
			return true;

		if(!array_key_exists($name, $_FILES) || $_FILES[$name]["error"] != UPLOAD_ERR_OK) // Check whether the file has been uploaded
			return false;

		if($this->mimeType !== null)
		{
			$type = $_FILES[$name]["type"]; // Identified mime type of the upload

			if(is_string($this->mimeType) && $type !== $this->mimeType) // Check if mimetype of the file corresponds to what we require
				return false;
			else if(is_array($this->mimeType))
			{
				foreach($this->mimeType as $mimeType) // If an array of mime types is given check whether a supported one exist
				{
					if($mimeType === $type)
						return true;
				}

				return false; // No supported mime types found
			}
		}

		return true;
	}
}
?>
