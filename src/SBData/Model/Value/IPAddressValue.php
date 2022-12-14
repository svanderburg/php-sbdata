<?php
namespace SBData\Model\Value;

/**
 * Stores a value and checks whether a user provided value is a IPv4 or IPv6 address.
 */
class IPAddressValue extends SaneStringValue
{
	/** Configuration flag to check for a valid IPv4 address */
	public const FLAG_IPV4 = 0x1;
	/** Configuration flag to check for a valid IPv6 address */
	public const FLAG_IPV6 = 0x2;
	/** Configuration flag that disallows private range IP addresses */
	public const FLAG_NO_PRIV_RANGE = 0x3;
	/** Configuration flag that disallows reserved IP addresses */
	public const FLAG_NO_RES_RANGE = 0x4;
	/** The default configuration flags */
	public const FLAG_DEFAULT = self::FLAG_IPV4 | self::FLAG_IPV6;

	/** Stores the configuration flags */
	public int $flags;

	/**
	 * Constructs a new IPAddressValue instance.
	 *
	 * @param $mandatory Indicates whether a given value is mandatory
	 * @param $flags Properties that need to be checked for (defaults to any valid IPv4 and IPv6 address)
	 * @param $defaultValue The value it defaults to
	 */
	public function __construct(bool $mandatory = false, int $flags = self::FLAG_DEFAULT, $defaultValue = null)
	{
		if($flags & self::FLAG_IPV6)
			$maxlength = 39;
		else
			$maxlength = 15;

		parent::__construct($mandatory, $maxlength, $defaultValue);
		$this->flags = $flags;
	}

	private function convertFlagsToFilterFlags(): int
	{
		$filterFlags = 0;

		if($this->flags & self::FLAG_IPV4)
			$filterFlags |= FILTER_FLAG_IPV4;

		if($this->flags & self::FLAG_IPV6)
			$filterFlags |= FILTER_FLAG_IPV6;

		if($this->flags & self::FLAG_NO_PRIV_RANGE)
			$filterFlags |= FILTER_FLAG_NO_PRIV_RANGE;

		if($this->flags & self::FLAG_NO_RES_RANGE)
			$filterFlags |= FILTER_FLAG_NO_RES_RANGE;

		return $filterFlags;
	}

	/**
	 * @see Value::checkValue()
	 */
	public function checkValue(string $name): bool
	{
		if(!parent::checkValue($name))
			return false;

		if($this->value === "")
			return true;
		else
		{
			$filterFlags = $this->convertFlagsToFilterFlags();
			return (filter_var($this->value, FILTER_VALIDATE_IP, $filterFlags) !== false);
		}
	}
}
?>
