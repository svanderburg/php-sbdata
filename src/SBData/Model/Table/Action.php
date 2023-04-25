<?php
namespace SBData\Model\Table;
use Closure;

/**
 * Encodes an action button for a table row
 */
class Action
{
	/** Function that generates the URL to a page that executes the action */
	public string|Closure $generateURLFunction;

	/** An optional icon */
	public ?string $icon;

	/**
	 * Constructs a new action instance.
	 *
	 * @param $generateURLFunction Function that generates the URL to a page that executes the action
	 * @param $icon An optional icon
	 */
	public function __construct(string|Closure $generateURLFunction, string $icon = null)
	{
		$this->generateURLFunction = $generateURLFunction;
		$this->icon = $icon;
	}
}
?>
