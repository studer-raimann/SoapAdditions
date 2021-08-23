<?php namespace srag\Plugins\SoapAdditions\Command\Favourites;

use srag\Plugins\SoapAdditions\Command\Base;

/**
 * Class AddToFavouritesCommand
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class AddToFavouritesCommand extends Base
{
    /**
     * @var int
     */
    private $ref_id;
    /**
     * @var int
     */
    private $object_id;
    /**
     * @var array
     */
    protected $user_ids = [];
    /**
     * @var false|mixed
     */
    protected $inherit;
    /**
     * @var \ilDBInterface
     */
    protected $database;
    /**
     * @var \ilFavouritesManager
     */
    protected $manager;

    public function __construct(int $ref_id, array $data)
    {
        global $DIC;
        $this->ref_id = $ref_id;
        $this->user_ids = (array) ($data['user_ids'] ?? []);
        $this->inherit = (bool) ($data['inherit'] ?? false);
        $this->manager = new \ilFavouritesManager();
        $this->database = $DIC->database();
    }

    public function run()
    {
        $this->initObjectId();
        $this->initUserIds();
        foreach ($this->user_ids as $user_id) {
            $this->manager->add($user_id, $this->ref_id);
        }
        return $this->user_ids;
    }

    /** @noinspection PhpCastIsUnnecessaryInspection */
    protected function initObjectId()
    {
        if (!\ilObject2::_exists($this->ref_id, true)) {
            throw new \ilSoapPluginException('no object found for ref_id ' . $this->ref_id);
        }
        $this->object_id = (int) \ilObject2::_lookupObjId($this->ref_id);
        if ($this->object_id === 0) {
            throw new \ilSoapPluginException('no object found for ref_id ' . $this->ref_id);
        }
    }

    /** @noinspection PhpCastIsUnnecessaryInspection */
    protected function initUserIds()
    {
        if ($this->inherit) {
            if ($this->object_id) {
                $r = $this->database->queryF(
                    "SELECT usr_id FROM obj_members WHERE obj_id = %s",
                    ['integer'],
                    [$this->object_id]
                );
            }
            $user_ids = [];
            /** @noinspection PhpParamsInspection */
            while ($d = $this->database->fetchObject($r)) {
                $user_ids[] = (int) $d->usr_id;
            }
            $this->user_ids = array_merge($this->user_ids, $user_ids);
        }
        $this->user_ids = array_unique($this->user_ids);
        $this->user_ids = array_filter($this->user_ids, static function ($user_id) : bool {
            return \ilObjUser::_exists($user_id, false);
        });
    }

}
