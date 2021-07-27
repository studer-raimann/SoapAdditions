<?php

namespace srag\Plugins\SoapAdditions\Routes\User;

use ilSoapPluginException;
use srag\Plugins\SoapAdditions\Routes\Base;
use srag\Plugins\SoapAdditions\Command\User\Settings as UserSettingsCommand;

/**
 * Class Settings
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Settings extends Base
{
    const P_USER_ID = 'user_id';
    const PREFIX_SHOW = 'show_';
    const P_ACTIVATE_PUBLIC_PROFILE = 'activate_public_profile';
    /**
     * @var \ilUserSettingsConfig
     */
    protected $user_settings_config;

    public function __construct()
    {
        parent::__construct();
        $this->user_settings_config = new \ilUserSettingsConfig();
    }

    /**
     * @param array $params
     * @return bool|mixed
     * @throws ilSoapPluginException
     */
    protected function run(array $params)
    {
        $command = new UserSettingsCommand((int) $params[self::P_USER_ID], $params);
        $command->run();
        if ($command->wasSuccessful()) {
            return true;
        }
        $this->error($command->getUnsuccessfulReason());

        return true;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "updateUserSettings";
    }

    /**
     * @return array
     */
    protected function getAdditionalInputParams() : array
    {
        $params = [
            $this->param_factory->int(self::P_USER_ID),
            $this->param_factory->bool(self::P_ACTIVATE_PUBLIC_PROFILE)
        ];

        $possible_values = [
            "title",
            "birthday",
            "gender",
            "upload",
            "interests_general",
            "interests_help_offered",
            "interests_help_looking",
            "org_units",
            "institution",
            "department",
            "street",
            "zipcode",
            "city",
            "country",
            "sel_country",
            "phone_office",
            "phone_home",
            "phone_mobile",
            "fax",
            "email",
            "second_email",
            "hobby",
            "matriculation"
        ];

        foreach ($possible_values as $possible_value) {
            if ($this->user_settings_config->isVisible($possible_value)) {
                $params[] = $this->param_factory->bool(self::PREFIX_SHOW . '' . $possible_value);
            }
        }

        return $params;
    }

    /**
     * @inheritdoc
     */
    public function getOutputParams()
    {
        return ['success' => Base::TYPE_BOOL];
    }

    /**
     * @inheritdoc
     */
    public function getShortDocumentation()
    {
        return "Updates the settings of a course to the data given";
    }

    protected function getSampleRequest()
    {
        return "";
    }

}
