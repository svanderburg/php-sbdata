<?php
namespace SBData\Model\Table\Anchor;
use SBData\Model\Form;
use SBData\Model\Value\IntegerValue;

/**
 * Contains utility functions that can be used to work with anchors in table rows
 * that can be used to track where actions (e.g. modifications) originated from.
 */
class AnchorRow
{
	private static function checkRowParameter(string $paramName): ?int
	{
		$value = new IntegerValue(true);
		if(array_key_exists($paramName, $_REQUEST))
			$value->value = $_REQUEST[$paramName];

		if($value->checkValue($paramName))
			return (int)($value->value);
		else
			return null;
	}

	/**
	 * Composes a fragment that can be appended to a redirection URL to move
	 * the user back to the corresponding row where the action originated
	 * from.
	 *
	 * @param $prefix Prefix of the anchor identifying the row
	 * @param $paramName Name of the REQUEST parameter containing the row number
	 * @return A redirection fragment if the provided row parameter
	 *   is exists and correct, otherwise an empty string
	 */
	public static function composeRowFragment(string $prefix = "table-row", string $paramName = "__id"): string
	{
		$row = AnchorRow::checkRowParameter($paramName);

		if($row === null)
			return "";
		else
			return "#".$prefix."-".$row;
	}

	/**
	 * Composes a fragment that can be appended to a redirection URL to move
	 * the user back to the row before the corresponding row where the action
	 * originated from.
	 *
	 * @param $prefix Prefix of the anchor identifying the row
	 * @param $paramName Name of the REQUEST parameter containing the row number
	 * @return A redirection fragment if the provided row parameter
	 *   is exists and correct, otherwise an empty string
	 */
	public static function composePreviousRowFragment(string $prefix = "table-row", string $paramName = "__id"): string
	{
		$row = AnchorRow::checkRowParameter($paramName);

		if($row === null)
			return "";
		else
		{
			if($row > 0)
				return "#".$prefix."-".($row - 1);
			else
				return "#".$prefix."-".$row;
		}
	}

	/**
	 * Composes a fragment that can be appended to a redirection URL to move
	 * the user back to the row after the corresponding row where the action
	 * originated from.
	 *
	 * @param $prefix Prefix of the anchor identifying the row
	 * @param $paramName Name of the REQUEST parameter containing the row number
	 * @return A redirection fragment if the provided row parameter
	 *   is exists and correct, otherwise an empty string
	 */
	public static function composeNextRowFragment(string $prefix = "table-row", string $paramName = "__id"): string
	{
		$row = AnchorRow::checkRowParameter($paramName);

		if($row === null)
			return "";
		else
			return "#".$prefix."-".($row + 1);
	}

	/**
	 * Composes a GET parameter that refers to the row of a table.
	 *
	 * @param $form representing the fields of the table row including the __id field that gives every row a unique number.
	 * @param $paramName Name of the parameter that propagates the row number
	 * @param $prefix Prefix of the provided parameter string
	 * @return A GET parameter referring to the current row
	 */
	public static function composeRowParameter(Form $form, string $paramName = "__id", string $prefix = "&amp;"): string
	{
		$row = $form->fields[$paramName]->exportValue();
		return $prefix.$paramName."=".$row;
	}
}
?>
