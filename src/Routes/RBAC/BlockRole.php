<?php

namespace srag\Plugins\SoapAdditions\Routes\RBAC;

use srag\Plugins\SoapAdditions\Command\RBAC\BlockRole as BlockRoleCommand;
use srag\Plugins\SoapAdditions\Routes\Base;

/**
 * Class BlockRole
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class BlockRole extends Base
{

    const P_ROLE_ID = 'role_id';
    const P_NODE_ID = 'node_id';

    public function getCommand(array $params)
    {
        $role_id = (int) $params[self::P_ROLE_ID];
        $node_id = (int) $params[self::P_NODE_ID];

        return new BlockRoleCommand($role_id, $node_id);
    }

    public function getName()
    {
        return "blockRole";
    }

    public function getAdditionalInputParams() : array
    {
        return [
            $this->param_factory->int(self::P_ROLE_ID, 'Internal ID of a Role'),
            $this->param_factory->int(self::P_NODE_ID, 'ILIAS Ref-ID of the Object'),
        ];
    }

    public function getOutputParams() : array
    {
        return [$this->param_factory->bool('success')];
    }

    public function getShortDocumentation()
    {
        return "Block a ILIAS Role (role_id) at the given node (node_id, e.g. a Course-Ref-ID)";
    }
}
