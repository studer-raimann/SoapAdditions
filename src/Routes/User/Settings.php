<?php

namespace srag\Plugins\SoapAdditions\Routes\User;

use ilSoapPluginException;
use srag\Plugins\SoapAdditions\Command\Course\Settings as SettingsCommand;
use srag\Plugins\SoapAdditions\Routes\Base;

/**
 * Class Settings
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Settings extends Base
{

    const P_USER_ID = 'user_id';

    /**
     * @param array $params
     * @return bool|mixed
     * @throws ilSoapPluginException
     */
    protected function run(array $params)
    {
        $command = new SettingsCommand((int) $params[self::P_COURSE_REF_ID]);
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
        return [
            $this->param_factory->int(self::P_USER_ID)
        ];
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
