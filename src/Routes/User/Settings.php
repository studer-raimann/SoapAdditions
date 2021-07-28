<?php

namespace srag\Plugins\SoapAdditions\Routes\User;

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

    public function getCommand(array $params)
    {
        return new UserSettingsCommand((int) $params[self::P_USER_ID], $params);
    }

    public function getName()
    {
        return "updateUserSettings";
    }

    public function getAdditionalInputParams() : array
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
            $params[] = $this->param_factory->bool(self::PREFIX_SHOW . '' . $possible_value);
        }

        return $params;
    }

    public function getOutputParams() : array
    {
        return [$this->param_factory->bool('success')];
    }

    public function getShortDocumentation()
    {
        return "Updates the settings of a course to the data given";
    }

    public function getSampleRequest()
    {
        return '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:updateUserSettings soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">?</sid>
         <user_id xsi:type="xsd:int">?</user_id>
         <activate_public_profile xsi:type="xsd:boolean">?</activate_public_profile>
         <show_title xsi:type="xsd:boolean">?</show_title>
         <show_birthday xsi:type="xsd:boolean">?</show_birthday>
         <show_gender xsi:type="xsd:boolean">?</show_gender>
         <show_upload xsi:type="xsd:boolean">?</show_upload>
         <show_interests_general xsi:type="xsd:boolean">?</show_interests_general>
         <show_interests_help_offered xsi:type="xsd:boolean">?</show_interests_help_offered>
         <show_interests_help_looking xsi:type="xsd:boolean">?</show_interests_help_looking>
         <show_org_units xsi:type="xsd:boolean">?</show_org_units>
         <show_institution xsi:type="xsd:boolean">?</show_institution>
         <show_department xsi:type="xsd:boolean">?</show_department>
         <show_street xsi:type="xsd:boolean">?</show_street>
         <show_zipcode xsi:type="xsd:boolean">?</show_zipcode>
         <show_city xsi:type="xsd:boolean">?</show_city>
         <show_country xsi:type="xsd:boolean">?</show_country>
         <show_sel_country xsi:type="xsd:boolean">?</show_sel_country>
         <show_phone_office xsi:type="xsd:boolean">?</show_phone_office>
         <show_phone_home xsi:type="xsd:boolean">?</show_phone_home>
         <show_phone_mobile xsi:type="xsd:boolean">?</show_phone_mobile>
         <show_fax xsi:type="xsd:boolean">?</show_fax>
         <show_email xsi:type="xsd:boolean">?</show_email>
         <show_second_email xsi:type="xsd:boolean">?</show_second_email>
         <show_hobby xsi:type="xsd:boolean">?</show_hobby>
         <show_matriculation xsi:type="xsd:boolean">?</show_matriculation>
      </urn:updateUserSettings>
   </soapenv:Body>
</soapenv:Envelope>';
    }

}
