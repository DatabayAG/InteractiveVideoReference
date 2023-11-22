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
        if (null !== self::$instance) {
            return self::$instance;
        }

        return (self::$instance = \ilPluginAdmin::getPluginObject(
            self::CTYPE,
            self::CNAME,
            self::SLOT_ID,
            self::PNAME
        ));
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
