<?php

namespace Wowtransfer;

class PlayerDump
{
	/**
	 * @return array
	 * @todo loading from wowtransfer.com with locale
	 */
	public static function getDumpFields()
	{
		return [
			'achievement' => [],
			'action' => [],
			'bind' => [],
			'bag' => [],
			'bank' => [],
			'criterias' => [],
			'critter' => [],
			'currency' => [],
			'equipment' => ['disabled' => 1],
			'glyph' => [],
			'inventory' => [],
			'mount' => [],
			'pmacro' => ['disabled' => 1],
			'quest' => [],
			'questlog' => [],
			'reputation' => [],
			'skill' => [],
			'skillspell' => [],
			'spell' => [],
			'statistic' => [],
			'talent' => [],
			'taxi' => [],
			'title' => [],
		];
	}

	/**
	 * @return array
	 */
	public static function getDumpFieldsNames()
	{
		return array_keys(self::getDumpFields());
	}
}
