<?php
/* Copyright (c) 1998-2016 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once 'Services/Repository/classes/class.ilRepositoryExplorerGUI.php';

/**
 * Class ilInteractiveVideoReferenceSelectionExplorerGUI
 * @author Michael Jansen <mjansen@databay.de>
 */
class ilInteractiveVideoReferenceSelectionExplorerGUI extends ilRepositoryExplorerGUI
{
	/**
	 * {@inheritdoc}
	 */
	public function __construct($a_parent_obj, $a_parent_cmd)
	{
		parent::__construct($a_parent_obj, $a_parent_cmd);
		$this->setTypeWhiteList(array('root', 'cat', 'crs', 'grp', 'fold', 'xvid'));
	}

	/**
	 * {@inheritdoc}
	 */
	protected function isNodeSelectable($a_node)
	{
		return in_array($a_node['type'], array('xvid'));
	}
}