<?php
/**
 * @file
 * @brief View-HTML-PagedDBTable module
 * @defgroup View-HTML-PagedDBTable
 * @{
 */

namespace SBData\View\HTML;
use SBData\Model\Table\PagedDBTable;
use SBData\Model\Form;

/**
 * Displays a paged database table with fields in a non-editable way.
 *
 * @param $table Paged database table to display
 * @param $requestParameters An array containing request parameters, e.g. $_GET/$_POST/$_REQUEST
 * @param $noItemsLabel Label to be displayed when there are no items in the table
 * @param $previousLabel Label of the previous button
 * @param $nextLabel Label of the next button
 * @param $anchorPrefix The prefix that the hidden anchor elements should have
 */
function displayPagedDBTable(PagedDBTable $table, array $requestParameters, string $noItemsLabel = "No items", string $previousLabel = "&laquo; Previous", string $nextLabel = "Next &raquo;", string $anchorPrefix = "table-row"): void
{
	displayPagesNavigation($table->pager, $requestParameters, $previousLabel, $nextLabel);
	displayTable($table, $noItemsLabel, $anchorPrefix);
	displayPagesNavigation($table->pager, $requestParameters, $previousLabel, $nextLabel);
}

/**
 * Displays a paged database table with fields in a semi-editable way. In this table, fields can
 * not be edited, but there are edit and delete buttons.
 *
 * @param $table Paged database table to display
 * @param $requestParameters An array containing request parameters, e.g. $_GET/$_POST/$_REQUEST
 * @param $noItemsLabel Label to be displayed when there are no items in the table
 * @param $previousLabel Label of the previous button
 * @param $nextLabel Label of the next button
 * @param $anchorPrefix The prefix that the hidden anchor elements should have
 */
function displaySemiEditablePagedDBTable(PagedDBTable $table, array $requestParameters, string $noItemsLabel = "No items", string $previousLabel = "&laquo; Previous", string $nextLabel = "Next &raquo;", string $anchorPrefix = "table-row"): void
{
	displayPagesNavigation($table->pager, $requestParameters, $previousLabel, $nextLabel);
	displaySemiEditableTable($table, $noItemsLabel, $anchorPrefix);
	displayPagesNavigation($table->pager, $requestParameters, $previousLabel, $nextLabel);
}

/**
 * Displays a paged database table with fields in an editable way. In this table, fields can be directly edited.
 *
 * @param $table Paged database table to display
 * @param $requestParameters An array containing request parameters, e.g. $_GET/$_POST/$_REQUEST
 * @param $submittedForm Form that contains the last submitted data that has changed, or null if no data was submitted
 * @param $noItemsLabel Label to be displayed when there are no items in the table
 * @param $editLabel Label to be displayed on the edit button
 * @param $previousLabel Label of the previous button
 * @param $nextLabel Label of the next button
 * @param $anchorPrefix The prefix that the hidden anchor elements should have
 */
function displayEditablePagedDBTable(PagedDBTable $table, array $requestParameters, Form $submittedForm = null, string $noItemsLabel = "No items", string $editLabel = "Edit", string $previousLabel = "&laquo; Previous", string $nextLabel = "Next &raquo;", string $anchorPrefix = "table-row"): void
{
	displayPagesNavigation($table->pager, $requestParameters, $previousLabel, $nextLabel);
	displayEditableTable($table, $submittedForm, $noItemsLabel, $editLabel, $anchorPrefix);
	displayPagesNavigation($table->pager, $requestParameters, $previousLabel, $nextLabel);
}

/**
 * @}
 */
?>
