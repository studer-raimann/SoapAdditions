<?php namespace srag\Plugins\SoapAdditions\Command\Favourites;

use srag\Plugins\SoapAdditions\Command\Base;

/**
 * Class AddToFavouritesCommand
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class AddToFavouritesCommand extends Base
{
    private $ref_id;
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
        $this->initUserIds();
        foreach ($this->user_ids as $user_id) {
            $this->manager->add($user_id, $this->ref_id);
        }
        return $this->user_ids;
    }

    /** @noinspection PhpCastIsUnnecessaryInspection */
    protected function initUserIds()
    {
        if ($this->inherit) {
            $object_id = (int) \ilObject2::_lookupObjId($this->ref_id);
            $r = $this->database->queryF(
                "SELECT usr_id FROM obj_members WHERE obj_id = %s",
                ['integer'],
                [$object_id]
            );
            $user_ids = [];
            /** @noinspection PhpParamsInspection */
            while ($d = $this->database->fetchObject($r)) {
                $user_ids[] = (int) $d->usr_id;
            }
            $this->user_ids = array_merge($this->user_ids, $user_ids);
        }
        $this->user_ids = array_unique($this->user_ids);
    }

}
