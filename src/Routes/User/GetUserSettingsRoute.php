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

    public function getName() : string
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

    public function getSampleRequest() : string
    {
        return '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:getUserSettings soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">b5629ca27dbaa6c5e48cc660e2f1bfd9::default</sid>
         <user_id xsi:type="xsd:int">6</user_id>
      </urn:getUserSettings>
   </soapenv:Body>
</soapenv:Envelope>';
    }
}
