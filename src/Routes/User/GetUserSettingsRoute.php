<?php

namespace srag\Plugins\SoapAdditions\Routes\User;

/**
 * Class GetUserSettingsRoute
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class GetUserSettingsRoute extends UserBase
{
    public function getCommand(array $params) : \srag\Plugins\SoapAdditions\Command\Command
    {
        return new \srag\Plugins\SoapAdditions\Command\User\GetUserSettingsCommand((int) $params[self::P_USER_ID]);
    }

    public function getName()
    {
        return "getUserSettings";
    }

    public function getAdditionalInputParams() : array
    {
        return [
            $this->param_factory->int(self::P_USER_ID)->setOptional(false)
        ];
    }

    public function getOutputParams() : array
    {
        return $this->getParams();
    }

    public function getShortDocumentation() : string
    {
        return "Shows the settings of a user to the user_id given";
    }

}
