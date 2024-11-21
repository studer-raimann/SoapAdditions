<?php
/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Command\User;

use srag\Plugins\SoapAdditions\Command\Base;
use srag\Plugins\SoapAdditions\Routes\User\UpdateUserSettingsRoute as SettingsCommand;

/**
 * Class UpdateUserSettingsCommand
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class UpdateUserSettingsCommand extends Base
{
    public $user_object;
    protected array $params;

    /**
     * UpdateUserSettingsRoute constructor.
     * @param int   $user_id
     * @param array $params
     */
    public function __construct(protected int $user_id, array $params)
    {
        $this->params = $params ?? [];
    }

    /**
     * @return \ilObjUser
     */
    protected function getUser(): \ilObjUser
    {
        if (!property_exists($this, 'user_object') || $this->user_object === null) {
            $this->user_object = new \ilObjUser($this->user_id);
        }
        return $this->user_object;
    }

    public function run(): array
    {
        $profile = $this->params[SettingsCommand::P_ACTIVATE_PUBLIC_PROFILE] ?? 'n';
        $force_disable = false;
        switch ($profile) {
            case 'y':
            case 'g':
                $this->getUser()->setPref("public_profile", $profile);
                break;
            case 'n':
            default:
                $this->getUser()->setPref("public_profile", 'n');
                $this->getUser()->update();
                $force_disable = true;
                break;
        }

        foreach ($this->params as $k => $param) {
            if ($k === 'sid') {
                continue;
            }
            if ($k === SettingsCommand::P_ACTIVATE_PUBLIC_PROFILE) {
                continue;
            }
            if ($k === 'user_id') {
                continue;
            }
            /** @noinspection DisconnectedForeachInstructionInspection */
            if ($force_disable) {
                $param = false;
            }
            $k = str_replace(SettingsCommand::PREFIX_SHOW, "", $k);
            $this->getUser()->setPref("public_" . $k, $param ? "y" : "n");
        }
        $this->getUser()->update();

        return [true];
    }

}
