<?php
namespace SBData\Model\Field;
use Closure;
use SBData\Model\Value\NaturalNumberValue;

/**
 *
 * Represents the structure of an individual data element representing a natural number that can be used to
 * compose a link to another page.
 */
class NaturalNumberKeyLinkField extends GenericKeyLinkField
{
	/**
	 * Constructs a new NaturalNumberKeyLinkField instance
	 *
	 * @param $title Title of the field
	 * @param $composeURLFunction Function that composes the URL where the field should be linked to
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 * @param $maxValue Specifies the maximum value that is allowed or null if there is no upper boundary (defaults to null)
	 */
	public function __construct(string $title, string|Closure $composeURLFunction, bool $mandatory = false, int $maxlength = null, $defaultValue = null, int $maxValue = null)
	{
		parent::__construct($title, $composeURLFunction, new NaturalNumberValue($mandatory, $maxlength, $defaultValue, $maxValue));
	}
}
?>
