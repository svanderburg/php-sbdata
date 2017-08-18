<?php
namespace SBData\Model\Table\Anchor;
use SBData\Model\Form;
use SBData\Model\Field\NumericIntTextField;

/**
 * Contains utility functions that can be used to work with anchors in table rows
 * that can be used to track where actions (e.g. modifications) originated from.
 */
class AnchorRow
{
	/**
	 * Composes a fragment that can be appended to a redirection URL to move
	 * the user back to the corresponding row where the action originated
	 * from.
	 *
	 * @param string $prefix Prefix of the anchor identifying the row
	 * @param string $paramName Name of the REQUEST parameter containing the row number
	 * @return string A redirection fragment if the provided row parameter
	 *   is exists and correct, otherwise an empty string
	 */
	public static function composeRowFragment($prefix = "table-row", $paramName = "__id")
	{
		$rowField = new NumericIntTextField("Row number", false);
		if(array_key_exists($paramName, $_REQUEST))
			$rowField->value = $_REQUEST[$paramName];

		if($rowField->checkField($paramName))
			return "#".$prefix."-".$rowField->value;
		else
			return "";
	}

	/**
	 * Composes a GET parameter that refers to the previous row.
	 *
	 * @param Form $form representing the fields of the table row including the __id field that gives every row a unique number.
	 * @param string $paramName Name of the parameter that propagates the row number
	 * @param string $prefix Prefix of the provided parameter string
	 * @return A GET parameter referring to the previous row or an empty string if there is none
	 */
	public static function composePreviousRowParameter(Form $form, $paramName = "__id", $prefix = "&amp;")
	{
		$row = $form->fields['__id']->value;
		if($row > 0)
			return $prefix.$paramName."=".($row - 1);
		else
			return $prefix.$paramName."=".$row;
	}
}
?>
