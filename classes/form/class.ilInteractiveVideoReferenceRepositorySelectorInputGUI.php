<?php
/* Copyright (c) 1998-2016 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once 'Services/UIComponent/Explorer2/classes/class.ilExplorerSelectInputGUI.php';

/**
 * Class ilInteractiveVideoReferenceRepositorySelectorInputGUI
 * @author            Michael Jansen <mjansen@databay.de>
 * @ilCtrl_IsCalledBy ilInteractiveVideoReferenceRepositorySelectorInputGUI: ilFormPropertyDispatchGUI
 */
class ilInteractiveVideoReferenceRepositorySelectorInputGUI extends ilExplorerSelectInputGUI
{
    /**
     * @var ilInteractiveVideoReferenceSelectionExplorerGUI
     */
    protected ilExplorerBaseGUI $explorer_gui;

    /**
     * {@inheritdoc}
     */
    public function __construct($title, $a_postvar, $a_explorer_gui, $a_multi = false)
    {
        require_once 'Services/UIComponent/Overlay/classes/class.ilOverlayGUI.php';
        ilOverlayGUI::initJavascript();

        $this->explorer_gui = $a_explorer_gui;
        $this->explorer_gui->setSelectMode($a_postvar . '_sel', $a_multi);

        parent::__construct($title, $a_postvar, $this->explorer_gui, $a_multi);
        $this->setType('repository_select');
    }

    /**
     * {@inheritdoc}
     */
    public function getTitleForNodeId($a_id) : string
    {
        return ilObject::_lookupTitle(ilObject::_lookupObjId($a_id));
    }
}
