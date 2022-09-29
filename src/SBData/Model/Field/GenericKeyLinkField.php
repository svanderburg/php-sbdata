<?php
namespace SBData\Model\Field;
use SBData\Model\Value\Value;

/**
 * Represents the structure of an individual data element that can be used to
 * compose a link to another page.
 */
class GenericKeyLinkField extends VisibleField
{
	/** Name of the function that composes the URL where the field should be linked to */
	public string $composeURLFunction;

	/**
	 * Constructs a new GenericKeyLinkField instance.
	 *
	 * @param $title Title of the field
	 * @param $composeURLFunction Name of the function that composes the URL where the field should be linked to
	 * @param $value An object that stores and checks the value of the field
	 */
	public function __construct(string $title, string $composeURLFunction, Value $value)
	{
		parent::__construct($title, $value);
		$this->composeURLFunction = $composeURLFunction;
	}
}
?>
