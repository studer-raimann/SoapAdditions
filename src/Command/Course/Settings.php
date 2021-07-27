<?php namespace srag\Plugins\SoapAdditions\Command\Course;

use srag\Plugins\SoapAdditions\Command\Command;
use srag\Plugins\SoapAdditions\Command\Base;
use srag\Plugins\SoapAdditions\Routes\Course\Settings as SettingsRoute;

/**
 * Class Settings
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Settings extends Base implements Command
{
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
     * Settings constructor.
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
        $course->setUseNews($this->getParameterByKey(SettingsRoute::P_ACTIVATE_NEWS));
        $course->setNewsTimeline($this->getParameterByKey(SettingsRoute::P_ACTIVATE_TIMELINE));
        $course->setNewsTimelineLandingPage($this->getParameterByKey(SettingsRoute::P_ACTIVATE_TIMELINE_LANDINGS_PAGE));
        $course->setNewsTimelineAutoEntries($this->getParameterByKey(SettingsRoute::P_SHOW_NEWS_TIMELINE_AUTO_ENTRIES));

        $show_news_after = $this->getParameterByKey(SettingsRoute::P_SHOW_NEW_AFTER);
        \ilBlockSetting::_write('news', 'hide_news_per_date', $show_news_after ? 1 : 0, 0, $this->obj_id);
        \ilBlockSetting::_write('news', 'hide_news_date', $show_news_after, 0, $this->obj_id);
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
        $course->setStatusDetermination($this->getParameterByKey(SettingsRoute::P_PASSED_DETERMINATION) === 1 ? 1 : 2);
        $course->setAboStatus((int) $this->getParameterByKey(SettingsRoute::P_ACTIVATE_ADD_TO_FAVOURITES));
    }

    protected function handleContainerSetting()
    {
        \ilContainer::_writeContainerSetting($this->obj_id, 'hide_header_icon_and_title',
            !$this->getParameterByKey(SettingsRoute::P_SHOW_TITLE_AND_ICON));

        \ilContainer::_writeContainerSetting($this->obj_id, 'hide_top_actions',
            !$this->getParameterByKey(SettingsRoute::P_SHOW_HEADER_ACTIONS));
    }

    protected function handleSortingSettings()
    {
        $cs = \ilContainerSortingSettings::getInstanceByObjId($this->obj_id);
        $sorting = $this->getParameterByKey(SettingsRoute::P_SORTING);
        $cs->setSortMode($sorting);
        if ($sorting === 1) { // Manually
            $cs->setSortNewItemsOrder($this->getParameterByKey(SettingsRoute::P_ORDER_FOR_NEW_OBJECTS));
            $cs->setSortNewItemsPosition($this->getParameterByKey(SettingsRoute::P_POSITION_FOR_NEW_OBJECTS) === 'top' ? 0 : 1);
        }
        $cs->setSortDirection($this->getParameterByKey(SettingsRoute::P_SORTING_DIRECTION) === 'asc' ? 0 : 1);
        $cs->update();
    }

    public function run()
    {
        // Sorting Settings:
        $this->handleSortingSettings();
        // Container Settings
        $this->handleContainerSetting();
        // Course Settings
        $this->handleCourseSettings();
        // News Settings
        $this->handleNewsSettings();
        // Save Course Object
        $this->getCourseObject()->update();
    }

}
