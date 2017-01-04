<?php
/* Copyright (c) 1998-2017 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once 'Services/COPage/classes/class.ilPageComponentPluginGUI.php';

/**
 * Class ilInteractiveVideoReferencePlugin
 * @ilCtrl_isCalledBy ilInteractiveVideoReferencePluginGUI: ilPCPluggedGUI
 */
class ilInteractiveVideoReferencePluginGUI extends \ilPageComponentPluginGUI
{
	/**
	 * @inheritdoc
	 */
	public function executeCommand()
	{
		global $ilCtrl;

		$next_class = $ilCtrl->getNextClass();

		switch($next_class)
		{
			default:
				$cmd = $ilCtrl->getCmd();
				if(in_array($cmd, array('create', 'save', 'edit', 'edit2', 'update', 'cancel')))
				{
					$this->$cmd();
				}
				break;
		}
	}

	/**
	 * @inheritdoc
	 */
	public function insert()
	{
		global $tpl;

		$tpl->setContent('X');
	}

	/**
	 * @inheritdoc
	 */
	public function edit()
	{
		//$this->setTabs('edit');
	}

	/**
	 * @inheritdoc
	 */
	public function create()
	{
		global $lng;

		/*$properties = array(
			'value_1' => $form->getInput('val1'),
			'value_2' => $form->getInput('val2')
		);
		if ($this->createElement($properties))*/

		ilUtil::sendSuccess($lng->txt('msg_obj_modified'), true);
		$this->returnToParent();
	}

	/**
	 * @inheritdoc
	 */
	public function getElementHTML($a_mode, array $a_properties, $plugin_version)
	{
		// TODO: Implement getElementHTML() method.
		return 'HelloWorld';
	}

}