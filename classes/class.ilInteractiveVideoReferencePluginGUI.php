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
		/**
		 * @var $ilAccess ilAccessHandler
		 * @var $tree     ilTree
		 */
		global $ilAccess, $tree;

		if(!isset($a_properties['xvid_ref_id']) || !is_numeric($a_properties['xvid_ref_id']) || $a_properties['xvid_ref_id'] <= 0)
		{
			return '';
		}

		$ref_id = $a_properties['xvid_ref_id'];
		if(!ilObject::_exists($ref_id, true))
		{
			return '';
		}

		if($tree->isDeleted($ref_id))
		{
			return '';
		}

		if(!$ilAccess->checkAccess('visible', '', $ref_id))
		{
			return '';
		}

		$pl  = $this->getPlugin();
		$tpl = $pl->getTemplate('tpl.content.html');

		/**
		 * @var $xvid ilObjInteractiveVideo
		 */
		$xvid = ilObjectFactory::getInstanceByRefId($ref_id);

		$tpl->setVariable('TITLE', $xvid->getTitle());
		$tpl->setVariable('DESCRIPTION', $xvid->getDescription());
		$tpl->setVariable('ICON', ilObject::_getIcon($xvid->getId()));

		if($ilAccess->checkAccess('read', '', $ref_id))
		{
			$params = array();

			if('presentation' == $a_mode)
			{
				$url = parse_url(ILIAS_HTTP_PATH);
				$params['xvid_referrer'] = urlencode($url['scheme'] . '://' . $url['host'] . (isset($url['port']) ?  ':' . $url['port'] : '') . $_SERVER['REQUEST_URI']);
			}

			$params['xvid_referrer_ref_id'] = (int)$_GET['ref_id'];

			require_once 'Services/Link/classes/class.ilLink.php';
			$tpl->setVariable('LINK', ilLink::_getLink($ref_id, 'xvid', $params));
			$tpl->setVariable('LINK_TITLE', $xvid->getTitle());
		}

		return $tpl->get();
	}

}