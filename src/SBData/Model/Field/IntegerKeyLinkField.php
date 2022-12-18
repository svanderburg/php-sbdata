<?php
namespace SBData\Model\Field;
use Closure;
use SBData\Model\Value\IntegerValue;

/**
 *
 * Represents the structure of an individual data element representing an integer that can be used to
 * compose a link to another page.
 */
class IntegerKeyLinkField extends GenericKeyLinkField
{
	/**
	 * Constructs a new IntegerKeyLinkField instance
	 *
	 * @param $title Title of the field
	 * @param $composeURLFunction Function that composes the URL where the field should be linked to
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $maxlength Maximum size of the text field or null for infinite size
	 * @param $defaultValue The value it defaults to
	 * @param $minValue Specifies the minimum value that is allowed or null if there is no lower boundary (defaults to null)
	 * @param $maxValue Specifies the maximum value that is allowed or null if there is no upper boundary (defaults to null)
	 */
	public function __construct(string $title, string|Closure $composeURLFunction, bool $mandatory = false, int $maxlength = null, $defaultValue = null, int $minValue = null, int $maxValue = null)
	{
		parent::__construct($title, $composeURLFunction, new IntegerValue($mandatory, $maxlength, $defaultValue, $minValue, $maxValue));
	}
}
?>
