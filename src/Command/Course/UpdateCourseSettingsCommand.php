<?php namespace srag\Plugins\SoapAdditions\Command\Course;

use srag\Plugins\SoapAdditions\Command\Base;
use srag\Plugins\SoapAdditions\Routes\Course\UpdateCourseSettingsRoute as SettingsRoute;

/**
 * Class UpdateCourseSettingsCommand
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class UpdateCourseSettingsCommand extends Base
{
    const FORMAT = 'Y-m-d H:i:s';
    /**
     * @var int
     */
    protected $obj_id = 0;
    /**
     * @var int
     */
    protected $ref_id = 0;
    /**
     * @var array
     */
    protected $parameters;

    /**
     * UpdateUserSettingsRoute constructor.
     * @param int   $ref_id
     * @param array $parameters
     */
    public function __construct(int $ref_id, array $parameters)
    {
        $this->ref_id = $ref_id;
        $this->parameters = $parameters;
        $this->obj_id = \ilObject2::_lookupObjId($this->ref_id);
    }

    private function getParameterByKey(string $key)
    {
        return $this->parameters[$key] ?? null;
    }

    protected function handleNewsSettings()
    {
        $course = $this->getCourseObject();
        $activate_news = $this->getParameterByKey(SettingsRoute::P_ACTIVATE_NEWS);
        if ($activate_news !== null) {
            $course->setUseNews($activate_news);
        }
        $activate_timeline = $this->getParameterByKey(SettingsRoute::P_ACTIVATE_TIMELINE);
        if ($activate_timeline !== null) {
            $course->setNewsTimeline($activate_timeline);
        }
        $activate_new_timeline_landing_page = $this->getParameterByKey(SettingsRoute::P_ACTIVATE_TIMELINE_LANDINGS_PAGE);
        if ($activate_new_timeline_landing_page !== null) {
            $course->setNewsTimelineLandingPage($activate_new_timeline_landing_page);
        }
        $show_news_timeline_auto = $this->getParameterByKey(SettingsRoute::P_SHOW_NEWS_TIMELINE_AUTO_ENTRIES);
        if ($show_news_timeline_auto !== null) {
            $course->setNewsTimelineAutoEntries($show_news_timeline_auto);
        }
        $show_news_after_input = $this->getParameterByKey(SettingsRoute::P_SHOW_NEW_AFTER);
        if ($show_news_after_input !== null) {
            $date = new \DateTimeImmutable($show_news_after_input);
            $show_news_after = $date->format(self::FORMAT);
            if ($show_news_after === $show_news_after_input) {
                \ilBlockSetting::_write('news', 'hide_news_per_date', $show_news_after ? 1 : 0, 0, $this->obj_id);
                \ilBlockSetting::_write('news', 'hide_news_date', $show_news_after, 0, $this->obj_id);
            }
        } else {
            \ilBlockSetting::_write('news', 'hide_news_per_date', 0, 0, $this->obj_id);
        }
    }

    /**
     * @return \ilObjCourse
     */
    protected function getCourseObject() : \ilObjCourse
    {
        if (!isset($this->course_object)) {
            $this->course_object = new \ilObjCourse($this->ref_id, true);
        }
        return $this->course_object;
    }

    protected function handleCourseSettings()
    {
        $course = $this->getCourseObject();
        $passed_determination = $this->getParameterByKey(SettingsRoute::P_PASSED_DETERMINATION);
        if ($passed_determination !== null) {
            $course->setStatusDetermination($passed_determination === 1 ? 1 : 2);
        }

        $add_to_favourites = $this->getParameterByKey(SettingsRoute::P_ACTIVATE_ADD_TO_FAVOURITES);
        if ($add_to_favourites !== null) {
            $course->setAboStatus((int) $add_to_favourites);
        }

    }

    protected function handleContainerSetting()
    {
        $show_title_and_icon = $this->getParameterByKey(SettingsRoute::P_SHOW_TITLE_AND_ICON);
        if ($show_title_and_icon !== null) {
            \ilContainer::_writeContainerSetting($this->obj_id, 'hide_header_icon_and_title',
                !$show_title_and_icon);

        }

        $show_top_actions = $this->getParameterByKey(SettingsRoute::P_SHOW_HEADER_ACTIONS);
        if ($show_top_actions !== null) {
            \ilContainer::_writeContainerSetting($this->obj_id, 'hide_top_actions',
                !$show_top_actions);
        }

    }

    protected function handleSortingSettings()
    {
        /** @noinspection PhpParamsInspection */
        $cs = \ilContainerSortingSettings::getInstanceByObjId($this->obj_id);
        $sorting = $this->getParameterByKey(SettingsRoute::P_SORTING);
        if ($sorting !== null) {
            $cs->setSortMode($sorting);
            if ($sorting === 1) { // Manually
                $cs->setSortNewItemsOrder($this->getParameterByKey(SettingsRoute::P_ORDER_FOR_NEW_OBJECTS));
                $cs->setSortNewItemsPosition($this->getParameterByKey(SettingsRoute::P_POSITION_FOR_NEW_OBJECTS) === 'top' ? 0 : 1);
            }
            /** @noinspection PhpParamsInspection */
            $cs->setSortDirection($this->getParameterByKey(SettingsRoute::P_SORTING_DIRECTION) === 'asc' ? 0 : 1);
            $cs->update();
        }
    }

    protected function handleLearningProgressSettings()
    {
        $mode = $this->getParameterByKey(SettingsRoute::P_LEARNING_PROGRESS_MODE);
        if (in_array(
            $mode,
            [
                SettingsRoute::LP_OPTION_OBJECTS,
                SettingsRoute::LP_OPTION_OFF,
                SettingsRoute::LP_OPTION_TUTOR
            ],
            true)
        ) {
            $settings = new \ilLPObjSettings($this->obj_id);
            $settings->setMode($mode);
            $settings->update(false);
        }
    }

    public function run()
    {
        // Sorting UpdateUserSettingsRoute:
        $this->handleSortingSettings();
        // RouteContainer UpdateUserSettingsRoute
        $this->handleContainerSetting();
        // Course UpdateUserSettingsRoute
        $this->handleCourseSettings();
        // News UpdateUserSettingsRoute
        $this->handleNewsSettings();
        // Handle LearningProgress
        $this->handleLearningProgressSettings();
        // Save Course Object
        $this->getCourseObject()->update();

        return [true];
    }

}
