<?php
namespace SBData\Model\Value;

/**
 * Stores a value and checks whether it is a valid page number
 */
class PageValue extends NaturalNumberValue
{
	/**
	 * Constructs a new PageValue instance.
	 */
	public function __construct()
	{
		parent::__construct(false, null, 0, null);
	}
}
?>
