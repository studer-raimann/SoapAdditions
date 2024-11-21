<?php
/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

declare(strict_types=1);

namespace srag\Plugins\SoapAdditions\Command\ItemGroup;

use srag\Plugins\SoapAdditions\Command\Base;
use ilSoapPluginException;
use ilItemGroupItems;
use ilObject2;

/**
 * @author Thibeau Fuhrer <thibeau@sr.solutions>
 */
class AddToItemGroupCommand extends Base
{
    /**
     * @var int[]
     */
    protected array $ref_ids;

    /**
     * @param int   $target_ref_id
     * @param int[] $ref_ids
     * @param bool  $append
     */
    public function __construct(protected int $target_ref_id, array $ref_ids, protected bool $append)
    {
        $this->ref_ids = array_unique($ref_ids);
    }

    /**
     * @throws ilSoapPluginException
     */
    public function run(): mixed
    {
        $this->checkTargetRefId();
        $this->checkRefIds();

        $assignments = new ilItemGroupItems($this->target_ref_id);

        if ($this->append) {
            foreach ($this->ref_ids as $ref_id) {
                $assignments->addItem($ref_id);
            }
        } else {
            $assignments->setItems($this->ref_ids);
        }

        $assignments->update();

        return $this->ref_ids;
    }

    /**
     * @throws ilSoapPluginException
     */
    protected function checkTargetRefId(): void
    {
        if (!ilObject2::_exists($this->target_ref_id, true) ||
            'itgr' !== ilObject2::_lookupType($this->target_ref_id, true)
        ) {
            throw new ilSoapPluginException("Target ($this->target_ref_id) is not an ItemGroup (itgr).");
        }
    }

    /**
     * @throws ilSoapPluginException
     */
    protected function checkRefIds(): void
    {
        foreach ($this->ref_ids as $ref_id) {
            if (!ilObject2::_exists($ref_id, true)) {
                throw new ilSoapPluginException("Object ($ref_id) does not exist anymore.");
            }
        }
    }
}
