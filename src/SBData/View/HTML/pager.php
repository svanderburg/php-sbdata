<?php
/**
 * @file
 * @brief View-HTML-Pager module
 * @defgroup View-HTML-Pager
 * @{
 */

use SBData\Model\Pager;

/**
 * Displays a navigation bar allowing the user to navigate through pages.
 *
 * @param $pager Pager to display
 * @param $previousLabel Label of the previous button
 * @param $nextLabel Label of the next button
 */
function displayPagesNavigation(Pager $pager, string $previousLabel = "&laquo; Previous", string $nextLabel = "Next &raquo;"): void
{
	$numOfPages = ($pager->queryFunction)($pager->dbh, $pager->pageSize);

	if($numOfPages > 1)
	{
		?>
		<div class="pagesnavigation">
			<?php
			$currentPage = $pager->determineCurrentPage();

			if($currentPage > 0)
			{
				?>
				<a href="<?php print($pager->baseURL); ?>?<?php print($pager->paramName); ?>=<?php print($currentPage - 1); ?>"><?php print($previousLabel); ?></a>
				<a href="<?php print($pager->baseURL); ?>?<?php print($pager->paramName); ?>=0">0</a>
				<?php
			}
			?>
			<a href="<?php print($pager->baseURL); ?>?<?php print($pager->paramName); ?>=<?php print($currentPage); ?>" class="active_page"><?php print($currentPage); ?></a>
			<?php

			$lastPage = $numOfPages - 1;

			if($currentPage < $lastPage)
			{
				?>
				<a href="<?php print($pager->baseURL); ?>?<?php print($pager->paramName); ?>=<?php print($lastPage); ?>"><?php print($lastPage); ?></a>
				<a href="<?php print($pager->baseURL); ?>?<?php print($pager->paramName); ?>=<?php print($currentPage + 1); ?>"><?php print($nextLabel); ?></a>
				<?php
			}
			?>
		</div>
	<?php
	}
}

/**
 * @}
 */
?>
