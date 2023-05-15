<?php
namespace SBData\Model\Table;
use SBData\Model\ReadOnlyForm;
use SBData\Model\Form;
use SBData\Model\Label\Label;
use SBData\Model\Label\TextLabel;

/**
 * A table that presents and validates collections of data in an editable way. Each row is represented as a form and makes it possible to edit rows.
 */
class EditableTable extends Table
{
	/** Label to be displayed on the save button */
	public Label $saveLabel;

	/** Action URL where the user gets redirected to (defaults to same page) */
	public ?string $actionURL;

	/**
	 * Constructs a new EditableTable instance.
	 *
	 * @param $columns An associative array mapping field names to fields that should be checked and displayed
	 * @param $actions An associative array of labels mapping to function names displaying action links
	 * @param $noItemsLabel Label to be displayed when there are no items in the table
	 * @param $anchorPrefix The prefix that the hidden anchor elements should have
	 * @param $saveLabel Label to be displayed on the save button
	 * @param $actionURL Action URL where the user gets redirected to (defaults to same page)
	 * @param $identifyRows Indicates whether to add an extra column that can be used to track which row in the table is modified
	 * @param $idColumnName Name of the identity column
	 */
	public function __construct(array $columns, array $actions = null, string $noItemsLabel = "No items", string $anchorPrefix = "table-row", Label $saveLabel = null, string $actionURL = null, bool $identifyRows = true, string $idColumnName = "__id")
	{
		parent::__construct($columns, $actions, $noItemsLabel, $anchorPrefix, $identifyRows, $idColumnName);

		if($saveLabel === null)
			$this->saveLabel = new TextLabel("Save");
		else
			$this->saveLabel = $saveLabel;

		$this->actionURL = $actionURL;
	}

	/**
	 * @see Table#constructForm()
	 */
	public function constructForm(): ReadOnlyForm
	{
		return new Form($this->cloneColumnFields(), $this->actionURL, $this->saveLabel);
	}

}
?>
