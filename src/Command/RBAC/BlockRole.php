<?php namespace srag\Plugins\SoapAdditions\Command\RBAC;

use Exception;
use ilObject2;
use srag\Plugins\SoapAdditions\Command\Command;

/**
 * Class
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class BlockRole implements Command
{

    /**
     * @var int
     */
    private $role_id = 0;
    /**
     * @var int
     */
    private $node_id = 0;
    /**
     * @var bool
     */
    private $status = true;
    /**
     * @var string
     */
    private $error_message = "";

    /**
     * BlockRole constructor.
     * @param int $role_id
     * @param int $node_id
     */
    public function __construct($role_id, $node_id)
    {
        $this->isRole($role_id);
        $this->isNode($node_id);
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
    }

    /**
     * @inheritDoc
     */
    public function revert()
    {
        throw new \LogicException("unable to revert");
    }

    /**
     * @inheritDoc
     */
    public function wasSuccessful()
    {
        return $this->status;
    }

    /**
     * @inheritDoc
     */
    public function getUnsuccessfulReason()
    {
        return $this->error_message;
    }

    /**
     * @param $role_id
     * @param $node_id
     * @return bool
     */
    private function blockRole(/*int*/ $role_id, /*int*/ $node_id)/*:bool*/
    {
        global $DIC;
        try {
            // Set assign to 'y' only if it is a local role
            $assign = $DIC->rbac()->review()->isAssignable($role_id, $node_id) ? 'y' : 'n';

            // Delete permissions
            $DIC->rbac()->admin()->revokeSubtreePermissions($node_id, $role_id);

            // Delete template permissions
            $DIC->rbac()->admin()->deleteSubtreeTemplates($node_id, $role_id);

            // Assign to Role Folder
            $DIC->rbac()->admin()->assignRoleToFolder(
                $role_id,
                $node_id,
                $assign
            );

            // finally set blocked status
            $DIC->rbac()->admin()->setBlockedStatus(
                $role_id,
                $node_id,
                true
            );
        } catch (Exception $e) {
            $this->status        = false;
            $this->error_message = "There was an unexpected error blocking the role";
        }

        $this->status = true;
    }

    /**
     * @param int $role_id
     * @return bool
     */
    private function isRole(/*int*/ $role_id)/*:bool*/
    {
        if ($this->status === true) {
            $b = (bool) (ilObject2::_exists($role_id, false) && ilObject2::_lookupType($role_id, false) === "role");
            if (!$b) {
                $this->error_message = "The role_id given ($role_id) is not a role";
            }
            $this->status = $b;
        }
    }

    /**
     * @param int $node_id
     * @return bool
     */
    private function isNode(/*int*/ $node_id)/*:bool*/
    {
        if ($this->status === true) {
            $exists = (bool) (ilObject2::_exists($node_id, true));
            if (!$exists) {
                $this->error_message = "The node_id given ($node_id) does not exist";
            }
            $this->status = $exists;
        }
    }
}
