<?php
/*********************************************************************
 * This Code is licensed under the GPL-3.0 License and is Part of a
 * ILIAS Plugin developed by sr solutions ag in Switzerland.
 *
 * https://sr.solutions
 *
 *********************************************************************/

namespace srag\Plugins\SoapAdditions\Command\RBAC;

use Exception;
use ilObject2;
use srag\Plugins\SoapAdditions\Command\Base;

/**
 * Class BlockRoleCommand
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class BlockRoleCommand extends Base
{
    /**
     * @var int
     */
    private $role_id;
    /**
     * @var int
     */
    private $node_id;

    /**
     * BlockRoleRoute constructor.
     * @param int $role_id
     * @param int $node_id
     */
    public function __construct($role_id, $node_id)
    {
        $this->checkRole($role_id);
        $this->checkNode($node_id);
        $this->role_id = $role_id;
        $this->node_id = $node_id;
    }

    /**
     * @inheritDoc
     */
    public function run()
    {
        if ($this->status === true) {
            $this->blockRole($this->role_id, $this->node_id);
        }
        return [true];
    }

    /**
     * @param $role_id
     * @param $node_id
     */
    private function blockRole(int $role_id, int $node_id)
    {
        global $DIC;
        try {
            // Set assign to 'y' only if it is a local role
            $assign = $DIC->rbac()->review()->isAssignable($role_id, $node_id) ? 'y' : 'n';

            // Delete permissions
            /** @noinspection PhpParamsInspection */
            $DIC->rbac()->admin()->revokeSubtreePermissions($node_id, $role_id);

            // Delete template permissions
            /** @noinspection PhpParamsInspection */
            $DIC->rbac()->admin()->deleteSubtreeTemplates($node_id, $role_id);

            // Assign to Role Folder
            $DIC->rbac()->admin()->assignRoleToFolder(
                $role_id,
                $node_id,
                $assign
            );

            // finally set blocked status
            /** @noinspection PhpParamsInspection */
            $DIC->rbac()->admin()->setBlockedStatus(
                $role_id,
                $node_id,
                true
            );
        } catch (Exception $e) {
            $this->status = false;
            $this->error_message = "There was an unexpected error blocking the role";
        }

        $this->status = true;
    }

    /**
     * @param int $role_id
     * @return void
     * @noinspection UnnecessaryCastingInspection
     * @noinspection PhpCastIsUnnecessaryInspection
     */
    private function checkRole(int $role_id)
    {
        if ($this->status === true) {
            $b = (bool) (ilObject2::_exists($role_id, false) && ilObject2::_lookupType($role_id, false) === "role");
            $this->status = $b;
            if (!$b) {
                $this->error_message = "The role_id given ($role_id) is not a role";
            }
        }
    }

    /**
     * @param int $node_id
     * @noinspection PhpCastIsUnnecessaryInspection
     */
    private function checkNode(int $node_id)
    {
        if ($this->status === true) {
            $exists = (bool) (ilObject2::_exists($node_id, true));
            $this->status = $exists;
            if (!$exists) {
                $this->error_message = "The node_id given ($node_id) does not exist";
            }
        }
    }
}
