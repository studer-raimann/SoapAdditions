<?php namespace srag\Plugins\SoapAdditions\Command\User;

use srag\Plugins\SoapAdditions\Command\Command;
use srag\Plugins\SoapAdditions\Command\Base;
use srag\Plugins\SoapAdditions\Routes\User\UserBase;

/**
 * Class GetUserSettingsCommand
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class GetUserSettingsCommand extends Base implements Command
{
    protected $user_id = 0;

    /**
     * UpdateUserSettingsRoute constructor.
     * @param int   $user_id
     * @param array $params
     */
    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @return \ilObjUser
     */
    protected function getUser() : \ilObjUser
    {
        if (!isset($this->user_object)) {
            $this->user_object = new \ilObjUser($this->user_id);
        }
        return $this->user_object;
    }

    public function run() : ?array
    {
        $pref = $this->getUser()->getPref("public_profile") ?? 'n';

        $basic = [
            UserBase::P_USER_ID => $this->user_id,
            UserBase::P_ACTIVATE_PUBLIC_PROFILE => $pref
        ];

        foreach (UserBase::$possible_values as $possible_value) {
            $basic[UserBase::PREFIX_SHOW . $possible_value] = $this->getUser()->getPref("public_" . $possible_value) === 'y';
        }

        return $basic;
    }

}
