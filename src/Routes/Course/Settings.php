<?php

namespace srag\Plugins\SoapAdditions\Routes\Course;

use srag\Plugins\SoapAdditions\Command\Course\Settings as SettingsCommand;
use srag\Plugins\SoapAdditions\Routes\Base;

/**
 * Class Settings
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Settings extends Base
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

    public function getCommand(array $params)
    {
        return new SettingsCommand((int) $params[self::P_COURSE_REF_ID], $params);
    }

    public function getName()
    {
        return "updateCourseSettings";
    }

    public function getAdditionalInputParams() : array
    {
        return [
            $this->param_factory->int(self::P_COURSE_REF_ID),
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
      <urn:updateCourseSettings soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <sid xsi:type="xsd:string">?</sid>
         <ref_id xsi:type="xsd:int">?</ref_id>
         <show_title_and_icon xsi:type="xsd:boolean">?</show_title_and_icon>
         <show_header_actions xsi:type="xsd:boolean">?</show_header_actions>
         <passed_determination xsi:type="xsd:int">?</passed_determination>
         <sorting xsi:type="xsd:int">?</sorting>
         <sorting_direction xsi:type="xsd:string">?</sorting_direction>
         <activate_add_to_favourites xsi:type="xsd:boolean">?</activate_add_to_favourites>
         <position_for_new_objects xsi:type="xsd:string">?</position_for_new_objects>
         <order_for_new_objects xsi:type="xsd:int">?</order_for_new_objects>
         <learning_progress_mode xsi:type="xsd:int">?</learning_progress_mode>
         <activate_news xsi:type="xsd:boolean">?</activate_news>
         <activate_news_timeline xsi:type="xsd:boolean">?</activate_news_timeline>
         <activate_news_timeline_auto_entries xsi:type="xsd:boolean">?</activate_news_timeline_auto_entries>
         <activate_news_timeline_landing_page xsi:type="xsd:boolean">?</activate_news_timeline_landing_page>
      </urn:updateCourseSettings>
   </soapenv:Body>
</soapenv:Envelope>';
    }

}
