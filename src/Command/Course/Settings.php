<?php namespace srag\Plugins\SoapAdditions\Command\Course;

use srag\Plugins\SoapAdditions\Command\Command;
use srag\Plugins\SoapAdditions\Command\Base;

/**
 * Class Settings
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class Settings extends Base implements Command
{
    protected $obj_id = 0;
    protected $ref_id = 0;

    protected $show_title_and_icon;
    protected $show_header_actions;
    protected $passed_determination;
    protected $sorting;
    protected $sorting_direction;
    protected $position_for_new_objects;
    protected $order_for_new_objects;
    protected $activate_add_to_favourites;

    protected $learning_progress_mode;

    protected $activate_news;
    protected $activate_news_timeline;
    protected $activate_news_timeline_auto_entries;
    protected $activate_news_timeline_landing_page;
    protected $show_news_after_date;

    /**
     * Settings constructor.
     * @param int $ref_id
     */
    public function __construct(int $ref_id)
    {
        $this->ref_id = $ref_id;
        $this->obj_id = \ilObject2::_lookupObjId($this->ref_id);
    }

    protected function handleNewsSettings()
    {
        $course = $this->getCourseObject();
        $course->setUseNews($this->activate_news);
        $course->setNewsTimeline($this->activate_news_timeline);
        $course->setNewsTimelineLandingPage($this->activate_news_timeline_landing_page);
        $course->setNewsTimelineAutoEntries($this->activate_news_timeline_auto_entries);

        \ilBlockSetting::_write('news', 'hide_news_per_date', $this->show_news_after_date ? 1 : 0, 0, $this->obj_id);
        \ilBlockSetting::_write('news', 'hide_news_date', $this->show_news_after_date, 0, $this->obj_id);
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
        if (isset($this->passed_determination)) {
            $course->setStatusDetermination($this->passed_determination === 1 ? 1 : 2);
        }
        if (isset($this->activate_add_to_favourites)) {
            $course->setAboStatus((int) $this->activate_add_to_favourites);
        }
    }

    protected function handleContainerSetting()
    {
        if (isset($this->show_title_and_icon)) {
            \ilContainer::_writeContainerSetting($this->obj_id, 'hide_header_icon_and_title',
                !$this->show_title_and_icon);
        }

        if (isset($this->show_header_actions)) {
            \ilContainer::_writeContainerSetting($this->obj_id, 'hide_top_actions',
                !$this->show_header_actions);
        }
    }

    protected function handleSortingSettings()
    {
        $cs = \ilContainerSortingSettings::getInstanceByObjId($this->obj_id);
        if (isset($this->sorting)) {
            $cs->setSortMode($this->sorting);
            if ($this->sorting === 1) { // Manually
                $cs->setSortNewItemsOrder($this->order_for_new_objects);
                $cs->setSortNewItemsPosition($this->position_for_new_objects === 'top' ? 0 : 1);
            }
        }
        if (isset($this->sorting_direction)) {
            $cs->setSortDirection($this->sorting_direction === 'asc' ? 0 : 1);
        }
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

    /**
     * @param mixed $show_title_and_icon
     */
    public function setShowTitleAndIcon($show_title_and_icon)
    {
        $this->show_title_and_icon = $show_title_and_icon;
    }

    /**
     * @param mixed $show_header_actions
     */
    public function setShowHeaderActions($show_header_actions)
    {
        $this->show_header_actions = $show_header_actions;
    }

    /**
     * @param mixed $passed_determination
     */
    public function setPassedDetermination($passed_determination)
    {
        $this->passed_determination = $passed_determination;
    }

    /**
     * @param mixed $sorting
     */
    public function setSorting($sorting)
    {
        $this->sorting = $sorting;
    }

    /**
     * @param mixed $sorting_direction
     */
    public function setSortingDirection($sorting_direction)
    {
        $this->sorting_direction = $sorting_direction;
    }

    /**
     * @param mixed $position_for_new_objects
     */
    public function setPositionForNewObjects($position_for_new_objects)
    {
        $this->position_for_new_objects = $position_for_new_objects;
    }

    /**
     * @param mixed $order_for_new_objects
     */
    public function setOrderForNewObjects($order_for_new_objects)
    {
        $this->order_for_new_objects = $order_for_new_objects;
    }

    /**
     * @param mixed $activate_add_to_favourites
     */
    public function setActivateAddToFavourites($activate_add_to_favourites)
    {
        $this->activate_add_to_favourites = $activate_add_to_favourites;
    }

    /**
     * @param mixed $learning_progress_mode
     */
    public function setLearningProgressMode($learning_progress_mode)
    {
        $this->learning_progress_mode = $learning_progress_mode;
    }

    /**
     * @param mixed $activate_news
     */
    public function setActivateNews($activate_news)
    {
        $this->activate_news = $activate_news;
    }

    /**
     * @param mixed $activate_news_timeline
     */
    public function setActivateNewsTimeline($activate_news_timeline)
    {
        $this->activate_news_timeline = $activate_news_timeline;
    }

    /**
     * @param mixed $show_news_after_date
     */
    public function setShowNewsAfterDate($show_news_after_date)
    {
        $this->show_news_after_date = $show_news_after_date;
    }

    /**
     * @param mixed $activate_news_timeline_auto_entries
     */
    public function setActivateNewsTimelineAutoEntries($activate_news_timeline_auto_entries)
    {
        $this->activate_news_timeline_auto_entries = $activate_news_timeline_auto_entries;
    }

    /**
     * @param mixed $activate_news_timeline_landing_page
     */
    public function setActivateNewsTimelineLandingPage($activate_news_timeline_landing_page)
    {
        $this->activate_news_timeline_landing_page = $activate_news_timeline_landing_page;
    }

}
