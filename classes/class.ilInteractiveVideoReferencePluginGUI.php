<?php
/* Copyright (c) 1998-2017 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once 'Services/COPage/classes/class.ilPageComponentPluginGUI.php';

/**
 * Class ilInteractiveVideoReferencePlugin
 * @ilCtrl_isCalledBy ilInteractiveVideoReferencePluginGUI: ilPCPluggedGUI
 * @ilCtrl_Calls ilInteractiveVideoReferencePluginGUI: ilPropertyFormGUI
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
			case 'ilpropertyformgui':
				$ilCtrl->forwardCommand($this->getConfigurationForm());
				break;

			default:
				$cmd = $ilCtrl->getCmd();
				if(in_array($cmd, array('create', 'save', 'edit', 'update', 'cancel')))
				{
					$this->$cmd();
				}
				break;
		}
	}

	/**
	 * @return ilPropertyFormGUI
	 */
	protected function getConfigurationForm($a_create = false)
	{
		global $lng, $ilCtrl;

		require_once 'Services/Form/classes/class.ilPropertyFormGUI.php';

		$form = new ilPropertyFormGUI();
		$form->setTitle($lng->txt('settings'));
		$form->setFormAction($ilCtrl->getFormAction($this));

		$pl = $this->getPlugin();

		$pl->includeClass('form/class.ilInteractiveVideoReferenceSelectionExplorerGUI.php');
		$ilCtrl->setParameterByClass('ilformpropertydispatchgui', 'postvar', 'xvid_ref_id');
		$explorer_gui = new ilInteractiveVideoReferenceSelectionExplorerGUI(
			array('ilpropertyformgui', 'ilformpropertydispatchgui', 'ilInteractiveVideoReferenceRepositorySelectorInputGUI'),
			'handleExplorerCommand'
		);

		$pl->includeClass('form/class.ilInteractiveVideoReferenceRepositorySelectorInputGUI.php');
		$sap_root_ref_id = new ilInteractiveVideoReferenceRepositorySelectorInputGUI(
			$pl->txt('xvid_ref_id'),
			'xvid_ref_id', $explorer_gui, false
		);
		$sap_root_ref_id->setRequired(true);
		$sap_root_ref_id->setInfo($pl->txt('xvid_ref_id_info'));
		$form->addItem($sap_root_ref_id);

		if($a_create)
		{
			$this->addCreationButton($form);
			$form->addCommandButton('cancel', $lng->txt('cancel'));
		}
		else
		{
			$form->addCommandButton('update', $lng->txt('save'));
			$form->addCommandButton('cancel', $lng->txt('cancel'));
		}

		return $form;
	}

	/**
	 * @inheritdoc
	 */
	public function insert()
	{
		global $tpl;

		$form = $this->getConfigurationForm(true);
		$tpl->setContent($form->getHTML());
	}

	/**
	 * @inheritdoc
	 */
	public function create()
	{
		global $tpl, $lng;

		$form = $this->getConfigurationForm(true);
		if($form->checkInput())
		{
			$properties = array(
				'xvid_ref_id' => $form->getInput('xvid_ref_id')
			);

			if($this->createElement($properties))
			{
				ilUtil::sendSuccess($lng->txt('msg_obj_modified'), true);
				$this->returnToParent();
			}
		}

		$form->setValuesByPost();
		$tpl->setContent($form->getHtml());
	}

	/**
	 * @inheritdoc
	 */
	public function edit()
	{
		global $tpl;

		$properties = $this->getProperties();

		$form = $this->getConfigurationForm();
		$form->setValuesByArray(array(
			'xvid_ref_id' => $properties['xvid_ref_id']
		));
		$tpl->setContent($form->getHTML());
	}

	/**
	 * 
	 */
	public function update()
	{
		global $tpl, $lng;

		$form = $this->getConfigurationForm();
		if($form->checkInput())
		{
			$properties = array(
				'xvid_ref_id' => $form->getInput('xvid_ref_id')
			);

			if($this->updateElement($properties))
			{
				ilUtil::sendSuccess($lng->txt('msg_obj_modified'), true);
				$this->returnToParent();
			}
		}

		$form->setValuesByPost();
		$tpl->setContent($form->getHtml());
	}

	/**
	 * 
	 */
	public function cancel()
	{
		$this->returnToParent();
	}

	/**
	 * @inheritdoc
	 */
	public function getElementHTML($a_mode, array $a_properties, $plugin_version)
	{
		// TODO: Implement getElementHTML() method.
		return $a_properties['xvid_ref_id'];
	}

}