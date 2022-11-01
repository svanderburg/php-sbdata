<?php
namespace SBData\Model\Value;

/**
 * Stores and checks whether a value contains an acceptable filename that can be safely used on a certain system.
 */
class AcceptableFileNameValue extends Value
{
	/** Indicates that we need to check whether the file name is valid on UNIX */
	public const FLAG_VALID_UNIX = 0x1;

	/** Indicates that we need to check whether the file name is valid on Windows */
	public const FLAG_VALID_WINDOWS = 0x2;

	/** Indicates that we want additional sanity checks */
	public const FLAG_SANE = 0x4;

	/** Indicates that all configuration flags need to be enabled */
	public const FLAG_ALL = self::FLAG_VALID_UNIX | self::FLAG_VALID_WINDOWS | self::FLAG_SANE;

	/** Flags that specify which filename properties to check */
	public int $flags;

	/**
	 * Constructs a new AcceptableFileNameValue instance.
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $flags Flags that specify which filename properties to check
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(bool $mandatory = false, int $maxlength = null, int $flags = self::FLAG_ALL, $defaultValue = null)
	{
		parent::__construct($mandatory, $maxlength, $defaultValue);
		$this->flags = $flags;
	}

	private function checkValidUNIXFileName(): bool
	{
		// UNIX file systems generally disallow / and \0 characters in a filename
		return !str_contains($this->value, "/") && !str_contains($this->value, "\0");
	}

	private function checkValidWindowsFileName(): bool
	{
		// Windows disallows the following characters: < > : " / \ | ? *
		if(preg_match("/[<>:\"\\/\\\\\\|?\\*]+/", $this->value) === 1)
			return false;

		// Windows disallows all control characters (ASCII numbers 0-31)
		if(preg_match("/[[:cntrl:]]/", $this->value) === 1)
			return false;

		// Windows disallows: CON, PRN, AUX, NUL, COM1, COM2, COM3, COM4, COM5, COM6, COM7, COM8, COM9, LPT1, LPT2, LPT3, LPT4, LPT5, LPT6, LPT7, LPT8, and LPT9
		// They are case insensitive and should also not be followed by an extension e.g. CON.txt

		$disallowedFileNames = array("CON", "PRN", "AUX", "NUL", "COM1", "COM2", "COM3", "COM4", "COM5", "COM6", "COM7", "COM8", "COM9", "LPT1", "LPT2", "LPT3", "LPT4", "LPT5", "LPT6", "LPT7", "LPT8", "LPT9");

		foreach($disallowedFileNames as $disallowedFileName)
		{
			if(strcasecmp($this->value, $disallowedFileName) == 0 || strcasecmp(substr($this->value, 0, strlen($disallowedFileName) + 1), $disallowedFileName.".") == 0)
				return false;
		}

		return true;
	}

	/**
	 * @see Value::checkValue()
	 */
	public function checkValue(string $name): bool
	{
		if(!parent::checkValue($name))
			return false;

		if($this->flags & self::FLAG_VALID_UNIX && !$this->checkValidUNIXFileName())
			return false;

		if($this->flags & self::FLAG_VALID_WINDOWS && !$this->checkValidWindowsFileName())
			return false;

		// Do not allow .. (is a parent dir)
		if($this->flags & self::FLAG_SANE && $this->value == "..")
			return false;

		return true;
	}
}
?>
