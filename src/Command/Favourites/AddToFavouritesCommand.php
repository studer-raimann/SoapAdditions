<?php /*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Command\Favourites;

use srag\Plugins\SoapAdditions\Command\Base;
use ILIAS\BackgroundTasks\Exceptions\InvalidArgumentException;

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
        if ($this->inherit && $this->ref_id) {
            try {
                $participants = \ilParticipants::getInstance($this->ref_id);
            } catch (InvalidArgumentException $e) {
                throw new \ilSoapPluginException('no participants found for ref_id' . $this->ref_id);
            }

            foreach ($participants->getParticipants() as $user_id) {
                $this->user_ids[] = (int) $user_id;
            }
        }

        $this->user_ids = array_unique($this->user_ids);
        $this->user_ids = array_filter($this->user_ids, function ($user_id) : bool {
            return $this->isUserIdValid($user_id);
        });
    }

    /**
     * Checks if the given value is a valid $user_id and returns whether the
     * user exists or not. (Considers a referential integrity issue inside
     * ILIAS by trying to create an instance)
     *
     * @param mixed $user_id
     */
    protected function isUserIdValid($user_id): bool
    {
        // checks for null, false or ''
        if (!$user_id) {
            return false;
        }

        try {
            $user = new \ilObjUser($user_id);
            return true;
        } catch (\Throwable $any) {
            return false;
        }
    }
}
