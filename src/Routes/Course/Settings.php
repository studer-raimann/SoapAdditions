<?php

namespace srag\Plugins\SoapAdditions\Routes\Course;

use ilSoapPluginException;
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

    /**
     * @param array $params
     * @return bool|mixed
     * @throws ilSoapPluginException
     */
    protected function run(array $params)
    {
        $command = new SettingsCommand((int) $params[self::P_COURSE_REF_ID], $params);
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
        return "updateCourseSettings";
    }

    /**
     * @return array
     */
    protected function getAdditionalInputParams()
    {
        return [
            self::P_COURSE_REF_ID => Base::TYPE_INT,
            // Ref-ID of course
            self::P_SHOW_TITLE_AND_ICON => Base::TYPE_BOOL,
            // true or false
            self::P_SHOW_HEADER_ACTIONS => Base::TYPE_BOOL,
            // true or false
            self::P_PASSED_DETERMINATION => Base::TYPE_INT,
            // 1: Through Learning Progress
            // 2: Only Manual by Tutors
            self::P_SORTING => Base::TYPE_INT,
            // 0: Titles in Alphabetical Order
            // 4: By Creation Date
            // 2: Sort by Activation
            // 1: Manually
            self::P_SORTING_DIRECTION => Base::TYPE_STRING,
            // asc (0) or desc (1)
            self::P_ACTIVATE_ADD_TO_FAVOURITES => Base::TYPE_BOOL,
            // true or false
            self::P_POSITION_FOR_NEW_OBJECTS => Base::TYPE_STRING,
            // top (0) or bottom (1)
            self::P_ORDER_FOR_NEW_OBJECTS => Base::TYPE_INT,
            // 0: Titles in Alphabetical Order
            // 1: By Creation Date
            // 2: Sort by Activation
            self::P_LEARNING_PROGRESS_MODE => Base::TYPE_INT,
            // 0: Learning Progress is Deactivated
            // 11: Tutors Monitor and Set Status
            // 5: Status is Determined by a Collection of Items
            self::P_ACTIVATE_NEWS => Base::TYPE_BOOL,
            // true or false
            self::P_ACTIVATE_TIMELINE => Base::TYPE_BOOL,
            // true or false
            self::P_SHOW_NEW_AFTER => Base::TYPE_STRING,
            // true or false
            self::P_SHOW_NEWS_TIMELINE_AUTO_ENTRIES => Base::TYPE_BOOL,
            // true or false
            self::P_ACTIVATE_TIMELINE_LANDINGS_PAGE => Base::TYPE_BOOL,
            // true or false
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
