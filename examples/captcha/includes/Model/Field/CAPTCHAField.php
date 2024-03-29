<?php
namespace Examples\CAPTCHA\Model\Field;
use SBData\Model\Field\RawTextField;

require_once(dirname(__FILE__)."/../../../simple-php-captcha.php");

/**
 * Represents a field showing a CAPTCHA image with a code that the user should
 * properly copy. This field wraps the functionality of the Simple PHP CAPTCHA
 * into a field that we integrate into the php-sbdata API.
 */
class CAPTCHAField extends RawTextField
{
	/** Base URL where the CAPTCHA script resides */
	public string $baseURL;

	/** Contains an instruction message shown to the user */
	public string $instruction;

	/** The simple PHP config object */
	public array $config;

	/**
	 * Constructs a new CAPTCHAField instance
	 *
	 * @param $title Title of the field
	 * @param $instruction Contains an instruction message shown to the user
	 * @param $maxlength Maximum size of the text field (defaults to 5)
	 * @param $baseURL Base URL where the CAPTCHA script resides
	 * @param $config The simple PHP config object
	 */
	public function __construct(string $title, string $instruction, int $maxlength = 5, string $baseURL = "", $config = array())
	{
		parent::__construct($title, true, $maxlength, $maxlength);
		$config['max_length'] = $maxlength; // Ensure that the provided max length matches the CAPTCHA's max length
		$this->instruction = $instruction;
		$this->baseURL = $baseURL;
		$this->config = $config;
		
		// Start a session for the CAPTCHA
		if(session_status() == PHP_SESSION_NONE)
			session_start();

		// Construct a new CAPTCHA when the page is loaded
		if($_SERVER["REQUEST_METHOD"] === "GET")
			$_SESSION['captcha'] = simple_php_captcha($this->config);

		// Provide package name so that we can use a custom display function in our own namespace
		$this->package = 'Examples\\CAPTCHA';
	}

	/**
	 * @see Field::checkField()
	 */
	public function checkField(string $name): bool
	{
		$valid = $this->exportValue() === $_SESSION['captcha']['code'];
		$_SESSION['captcha'] = simple_php_captcha($this->config); // Compose a new CAPTCHA in case the provided code was wrong
		return $valid;
	}
}
?>
