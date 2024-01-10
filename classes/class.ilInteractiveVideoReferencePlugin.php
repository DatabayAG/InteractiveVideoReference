<?php
/* Copyright (c) 1998-2017 ILIAS open source, Extended GPL, see docs/LICENSE */

require_once 'Services/COPage/classes/class.ilPageComponentPlugin.php';

/**
 * Class ilInteractiveVideoReferencePlugin
 */
class ilInteractiveVideoReferencePlugin extends \ilPageComponentPlugin
{
    /**
     * @var string
     */
    const CTYPE = 'Services';

    /**
     * @var string
     */
    const CNAME = 'COPage';

    /**
     * @var string
     */
    const SLOT_ID = 'pgcp';

    /**
     * @var string
     */
    const PNAME = 'InteractiveVideoReference';

    /**
     * @var self
     */
    private static $instance;
    /**
     * @var array
     */
    protected static $validParentTypes = array(
        'lm',
        'wpg',
        'cont',
        'copa'
    );

    /**
     * @return self|\ilPlugin|\ilUserInterfaceHookPlugin
     */
    public static function getInstance()
    {
        if (self::$instance instanceof self) {
            return self::$instance;
        }

        global $DIC;

        /** @var ilComponentRepository $component_repository */
        if(!isset($DIC['component.repository'])) {
            $component =  new InitComponentService();
            $component->init($DIC);
        }
        $component_repository = $DIC['component.repository'];
        /** @var ilComponentFactory $component_factory */
        $component_factory = $DIC['component.factory'];

        $plugin_info = $component_repository->getComponentByTypeAndName(
            self::CTYPE,
            self::CNAME
        )->getPluginSlotById(self::SLOT_ID)->getPluginByName(self::PNAME);

        self::$instance = $component_factory->getPlugin($plugin_info->getId());

        return self::$instance;

    }

    /**
     * @inheritdoc
     */
    public function isValidParentType($a_type) : bool
    {
        return in_array(strtolower($a_type), self::$validParentTypes);
    }

    /**
     * @inheritdoc
     */
    public function getPluginName() : string
    {
        return 'InteractiveVideoReference';
    }
}