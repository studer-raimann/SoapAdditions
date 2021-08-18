<?php

namespace srag\Plugins\SoapAdditions\Routes\Course;

use srag\Plugins\SoapAdditions\Command\Course\UpdateCourseSettingsCommand as SettingsCommand;
use srag\Plugins\SoapAdditions\Routes\Base;

/**
 * Class UpdateCourseSettingsRoute
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class UpdateCourseSettingsRoute extends Base
{

    const P_COURSE_REF_ID = 'ref_id';
    const P_SHOW_TITLE_AND_ICON = 'show_title_and_icon';
    const P_SHOW_HEADER_ACTIONS = 'show_header_actions';
    const P_PASSED_DETERMINATION = 'passed_determination';
    const P_SORTING = 'sorting';
    const P_SORTING_DIRECTION = 'sorting_direction';
    const P_ACTIVATE_ADD_TO_FAVOURITES = 'activate_add_to_favourites';
    const P_POSITION_FOR_NEW_OBJECTS = 'position_for_new_objects';
    const P_ORDER_FOR_NEW_OBJECTS = 'order_for_new_objects';
    const P_SORTING_DIRECTION_FOR_NEW_OBJECTS = 'sorting_direction_for_new_objects';

    const P_LEARNING_PROGRESS_MODE = 'learning_progress_mode';
    const P_ACTIVATE_NEWS = 'activate_news';
    const P_ACTIVATE_TIMELINE = 'activate_news_timeline';
    const P_SHOW_NEW_AFTER = 'show_news_after_date';
    const P_SHOW_NEWS_TIMELINE_AUTO_ENTRIES = 'activate_news_timeline_auto_entries';
    const P_ACTIVATE_TIMELINE_LANDINGS_PAGE = 'activate_news_timeline_landing_page';

    public function getCommand(array $params) : \srag\Plugins\SoapAdditions\Command\Command
    {
        return new SettingsCommand((int) $params['course_settings'][self::P_COURSE_REF_ID], $params['course_settings']);
    }

    public function getName()
    {
        return "updateCourseSettings";
    }

    public function getAdditionalInputParams() : array
    {
        $fields = [
            $this->param_factory->int(self::P_COURSE_REF_ID)->setOptional(false),
            $this->param_factory->bool(self::P_SHOW_TITLE_AND_ICON),
            $this->param_factory->bool(self::P_SHOW_HEADER_ACTIONS),
            $this->param_factory->int(self::P_PASSED_DETERMINATION, '', [
                $this->param_factory->possibleValue(1, 'Through Learning Progress'),
                $this->param_factory->possibleValue(2, 'Only Manual by Tutors'),
            ]),
            $this->param_factory->int(self::P_SORTING, '', [
                $this->param_factory->possibleValue(0, 'Titles in Alphabetical Order'),
                $this->param_factory->possibleValue(4, 'By Creation Date'),
                $this->param_factory->possibleValue(2, 'Sort by Activation'),
                $this->param_factory->possibleValue(1, 'Manually'),
            ]),
            $this->param_factory->string(self::P_SORTING_DIRECTION, '', [
                $this->param_factory->possibleValue('asc', 'ASC'),
                $this->param_factory->possibleValue('desc', 'DESC'),
            ]),
            $this->param_factory->bool(self::P_ACTIVATE_ADD_TO_FAVOURITES),
            $this->param_factory->string(self::P_POSITION_FOR_NEW_OBJECTS, '', [
                $this->param_factory->possibleValue('top', 'Top'),
                $this->param_factory->possibleValue('bottom', 'Bottom'),
            ]),
            $this->param_factory->int(self::P_ORDER_FOR_NEW_OBJECTS, '', [
                $this->param_factory->possibleValue(0, 'Titles in Alphabetical Order'),
                $this->param_factory->possibleValue(1, 'By Creation Date'),
                $this->param_factory->possibleValue(2, 'Sort by Activation'),
            ]),
            $this->param_factory->int(self::P_LEARNING_PROGRESS_MODE, '', [
                $this->param_factory->possibleValue(0, 'Learning Progress is Deactivated'),
                $this->param_factory->possibleValue(11, 'Tutors Monitor and Set Status'),
                $this->param_factory->possibleValue(5, 'Status is Determined by a Collection of Items'),
            ]),
            $this->param_factory->bool(self::P_ACTIVATE_NEWS),
            $this->param_factory->bool(self::P_ACTIVATE_TIMELINE),
            $this->param_factory->string(self::P_POSITION_FOR_NEW_OBJECTS, '', [
                $this->param_factory->possibleValue('top', 'Top'),
                $this->param_factory->possibleValue('bottom', 'Bottom'),
            ]),
            $this->param_factory->bool(self::P_SHOW_NEWS_TIMELINE_AUTO_ENTRIES),
            $this->param_factory->bool(self::P_ACTIVATE_TIMELINE_LANDINGS_PAGE),
        ];

        return [
            $this->param_factory->complex('course_settings', 'courseSettings', $fields)->setOptional(false)
        ];
    }

    public function getOutputParams() : array
    {
        return [$this->param_factory->bool('success')];
    }

    public function getShortDocumentation() : string
    {
        return "Updates the settings of a course (ref_id) to the data given";
    }

    public function getSampleRequest() : string
    {
        return '<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:SoapAdditions">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:updateCourseSettings soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">976d27aa4ba2c532d8905945b363eb26::default</sid>
         <course_settings xsi:type="urn:courseSettings" xmlns:urn="urn:ilUserAdministration">
            <!--You may enter the following 14 items in any order-->
            <ref_id xsi:type="xsd:int">76</ref_id>
            <!--Optional:-->
            <show_title_and_icon xsi:type="xsd:boolean">true</show_title_and_icon>
            <!--Optional:-->
            <show_header_actions xsi:type="xsd:boolean">true</show_header_actions>
            <!--Optional:-->
            <passed_determination xsi:type="xsd:int">2</passed_determination>
            <!--Optional:-->
            <sorting xsi:type="xsd:int">4</sorting>
            <!--Optional:-->
            <sorting_direction xsi:type="xsd:string">asc</sorting_direction>
            <!--Optional:-->
            <activate_add_to_favourites xsi:type="xsd:boolean">true</activate_add_to_favourites>
            <!--Optional:-->
            <position_for_new_objects xsi:type="xsd:string">top</position_for_new_objects>
            <!--Optional:-->
            <order_for_new_objects xsi:type="xsd:int">2</order_for_new_objects>
            <!--Optional:-->
            <learning_progress_mode xsi:type="xsd:int">5</learning_progress_mode>
            <!--Optional:-->
            <activate_news xsi:type="xsd:boolean">true</activate_news>
            <!--Optional:-->
            <activate_news_timeline xsi:type="xsd:boolean">true</activate_news_timeline>
            <!--Optional:-->
            <activate_news_timeline_auto_entries xsi:type="xsd:boolean">true</activate_news_timeline_auto_entries>
            <!--Optional:-->
            <activate_news_timeline_landing_page xsi:type="xsd:boolean">true</activate_news_timeline_landing_page>
         </course_settings>
      </urn:updateCourseSettings>
   </soapenv:Body>
</soapenv:Envelope>';
    }

}
