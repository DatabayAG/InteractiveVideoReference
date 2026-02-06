<?php
/* Copyright (c) 1998-2016 ILIAS open source, Extended GPL, see docs/LICENSE */


/**
 * Class ilInteractiveVideoReferenceSelectionExplorerGUI
 * @author Michael Jansen <mjansen@databay.de>
 */
class ilInteractiveVideoReferenceSelectionExplorerGUI extends ilRepositoryExplorerGUI
{
    protected string $id;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setId($id): void
    {
        $this->id = __CLASS__ . '_' . $id;
    }

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
    protected function isNodeSelectable($a_node) : bool
    {
        return $a_node['type'] === 'xvid';
    }

    public function getNodeHref($a_node) : string
    {
        return '#';
    }

}
