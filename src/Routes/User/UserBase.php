<?php

/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Routes\User;

use srag\Plugins\SoapAdditions\Routes\Base;

/**
 * Class UserBase
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
abstract class UserBase extends Base
{
    public static $possible_values = [
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
    const P_USER_ID = 'user_id';
    const PREFIX_SHOW = 'show_';
    const P_ACTIVATE_PUBLIC_PROFILE = 'activate_public_profile';

    protected function getParams() : array
    {
        $params = [
            $this->param_factory->int(self::P_USER_ID)->setOptional(false),
            $this->param_factory->string(self::P_ACTIVATE_PUBLIC_PROFILE, '', [
                $this->param_factory->possibleValue('n', 'Deactivated'),
                $this->param_factory->possibleValue('y', 'Internally activated'),
                $this->param_factory->possibleValue('g', 'Globally activated'),
            ])
        ];

        foreach (self::$possible_values as $possible_value) {
            $params[] = $this->param_factory->bool(self::PREFIX_SHOW . '' . $possible_value);
        }

        return [
            $this->param_factory->complex(
                'user_settings',
                'userSettings',
                $params
            )
        ];
    }

}
