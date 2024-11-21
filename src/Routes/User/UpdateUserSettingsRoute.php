<?php

/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Routes\User;

use srag\Plugins\SoapAdditions\Command\Command;
use srag\Plugins\SoapAdditions\Command\User\UpdateUserSettingsCommand;

/**
 * Class UpdateUserSettingsRoute
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class UpdateUserSettingsRoute extends UserBase
{
    public const P_USER_ID = 'user_id';
    public const PREFIX_SHOW = 'show_';
    public const P_ACTIVATE_PUBLIC_PROFILE = 'activate_public_profile';
    /**
     * @var \ilUserSettingsConfig
     */
    protected $user_settings_config;

    public function getCommand(array $params): Command
    {
        return new UpdateUserSettingsCommand((int) $params['user_settings'][self::P_USER_ID], $params['user_settings']);
    }

    public function getName(): string
    {
        return "updateUserSettings";
    }

    public function getAdditionalInputParams(): array
    {
        return $this->getParams();
    }

    public function getOutputParams(): array
    {
        return [$this->param_factory->bool('success')];
    }

    public function getShortDocumentation(): string
    {
        return "Updates the settings of a user to the data given";
    }

    public function getSampleRequest(): string
    {
        return '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:updateUserSettings soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">637ec4aaad34be151b7e1548e0a7515f::default</sid>
         <user_settings xsi:type="ns2:userSettings" xmlns:urn="urn:ilUserAdministration">
            <!--You may enter the following 25 items in any order-->
            <user_id xsi:type="xsd:int">6</user_id>
            <!--Optional:-->
            <activate_public_profile xsi:type="xsd:boolean">true</activate_public_profile>
            <!--Optional:-->
            <show_title xsi:type="xsd:boolean">true</show_title>
            <!--Optional:-->
            <show_birthday xsi:type="xsd:boolean">false</show_birthday>
            <!--Optional:-->
            <show_gender xsi:type="xsd:boolean">true</show_gender>
            <!--Optional:-->
            <show_interests_general xsi:type="xsd:boolean">true</show_interests_general>
            <!--Optional:-->
            <show_interests_help_offered xsi:type="xsd:boolean">true</show_interests_help_offered>
            <!--Optional:-->
            <show_interests_help_looking xsi:type="xsd:boolean">true</show_interests_help_looking>
            <!--Optional:-->
            <show_org_units xsi:type="xsd:boolean">true</show_org_units>
            <!--Optional:-->
            <show_institution xsi:type="xsd:boolean">true</show_institution>
            <!--Optional:-->
            <show_department xsi:type="xsd:boolean">true</show_department>
            <!--Optional:-->
            <show_street xsi:type="xsd:boolean">true</show_street>
            <!--Optional:-->
            <show_zipcode xsi:type="xsd:boolean">true</show_zipcode>
            <!--Optional:-->
            <show_city xsi:type="xsd:boolean">true</show_city>
            <!--Optional:-->
            <show_country xsi:type="xsd:boolean">true</show_country>
            <!--Optional:-->
            <show_sel_country xsi:type="xsd:boolean">true</show_sel_country>
            <!--Optional:-->
            <show_phone_office xsi:type="xsd:boolean">true</show_phone_office>
            <!--Optional:-->
            <show_phone_home xsi:type="xsd:boolean">true</show_phone_home>
            <!--Optional:-->
            <show_phone_mobile xsi:type="xsd:boolean">true</show_phone_mobile>
            <!--Optional:-->
            <show_fax xsi:type="xsd:boolean">true</show_fax>
            <!--Optional:-->
            <show_email xsi:type="xsd:boolean">true</show_email>
            <!--Optional:-->
            <show_second_email xsi:type="xsd:boolean">true</show_second_email>
            <!--Optional:-->
            <show_hobby xsi:type="xsd:boolean">true</show_hobby>
            <!--Optional:-->
            <show_matriculation xsi:type="xsd:boolean">true</show_matriculation>
         </user_settings>
      </urn:updateUserSettings>
   </soapenv:Body>
</soapenv:Envelope>';
    }

}
