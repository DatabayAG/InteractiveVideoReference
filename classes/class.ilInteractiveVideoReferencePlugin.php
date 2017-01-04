<?php
/* Copyright (c) 1998-2017 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once 'Services/COPage/classes/class.ilPageComponentPlugin.php';

/**
 * Class ilInteractiveVideoReferencePlugin
 */
class ilInteractiveVideoReferencePlugin extends \ilPageComponentPlugin
{
	/**
	 * @var array
	 */
	protected static $validParentTypes = array(
		'lm', 'wpg', 'cont'
	);

	/**
	 * @inheritdoc
	 */
	public function isValidParentType($a_type)
	{
		return in_array(strtolower($a_type), self::$validParentTypes);
	}

	/**
	 * @inheritdoc
	 */
	public function getPluginName()
	{
		return 'InteractiveVideoReference';
	}
}