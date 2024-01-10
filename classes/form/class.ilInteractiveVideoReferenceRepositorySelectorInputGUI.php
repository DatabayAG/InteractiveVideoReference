<?php
/* Copyright (c) 1998-2016 ILIAS open source, Extended GPL, see docs/LICENSE */

/**
 * Class ilInteractiveVideoReferenceRepositorySelectorInputGUI
 * @author            Michael Jansen <mjansen@databay.de>
 * @ilCtrl_IsCalledBy ilInteractiveVideoReferenceRepositorySelectorInputGUI: ilFormPropertyDispatchGUI
 */
class ilInteractiveVideoReferenceRepositorySelectorInputGUI extends ilExplorerSelectInputGUI
{
    protected ilExplorerBaseGUI $explorer_gui;

    /**
     * {@inheritdoc}
     */
    public function __construct($title, $a_postvar, $a_explorer_gui, $a_multi = false)
    {
        ilOverlayGUI::initJavascript();

        $this->explorer_gui = $a_explorer_gui;
        $this->explorer_gui->setSelectMode($a_postvar . '_sel', $a_multi);

        parent::__construct($title, $a_postvar, $this->explorer_gui, $a_multi);
        $this->setType('repository_select');
    }

    /**
     * @inheritdoc
     */
    public function setValue($a_value): void
    {
        if ($this->explorer_gui) {
            if (is_array($a_value)) {
                foreach ($a_value as $v) {
                    $this->explorer_gui->setNodeOpen($v);
                    $this->explorer_gui->setNodeSelected($v);
                }
            } elseif ($a_value != "") {
                $this->explorer_gui->setNodeOpen($a_value);
                $this->explorer_gui->setNodeSelected($a_value);
            }
        }

        parent::setValue($a_value);
    }

    /**
     * {@inheritdoc}
     */
    public function getTitleForNodeId($a_id) : string
    {
        return ilObject::_lookupTitle(ilObject::_lookupObjId($a_id));
    }
}
