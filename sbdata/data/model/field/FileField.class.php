<?php
require_once("TextField.class.php");

/**
 * Represents the structure of an individual data element containing a file reference.
 */
class FileField extends TextField
{
	/** Required MIME type for the file */
	public $mimeType;
	
	/**
	 * Constructs a new FileField instance
	 *
	 * @param string $title Title of the field
	 * @param string $mimeType Required MIME type for the file
	 * @param bool $mandatory Indicates whether a given value is mandatory
	 */
	public function __construct($title, $mimeType = null, $mandatory = false)
	{
		parent::__construct($title, $mandatory);
		$this->mimeType = $mimeType;
	}
	
	/**
	 * @see TextField::checkField()
	 */
	public function checkField($name)
	{
		if(!$this->mandatory && (!array_key_exists($name, $_FILES) || !array_key_exists("tmp_name", $_FILES[$name]) || $_FILES[$name]["tmp_name"] === "")) // If a file is not mandatory and no file has been provided then everything is ok
			return true;
		else
		{
			if(!array_key_exists($name, $_FILES) || $_FILES[$name]["error"] != UPLOAD_ERR_OK) // Check whether the file has been uploaded
				return false;
			
			if($this->mimeType !== null)
			{
				$type = $_FILES[$name]["type"]; // Identified mime type of the upload

				if(is_string($this->mimeType) && $type !== $this->mimeType) // Check if mimetype of the file corresponds to what we require
					return false;
				else if(is_array($this->mimeType))
				{
					foreach($this->mimeType as $mimeType) // If an array of mimetypes is given check whether a supported one exist
					{
						if($mimeType === $type)
							return true;
					}
					
					return false; // No supported mimetypes found
				}
			}

			return true;
		}
	}
}
?>
