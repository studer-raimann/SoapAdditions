<?php

namespace srag\Plugins\SoapAdditions\Routes\RBAC;

use ilSoapPluginException;
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

    /**
     * @param array $params
     * @return bool|mixed
     * @throws ilSoapPluginException
     */
    protected function run(array $params)
    {
        $role_id = (int) $params[self::P_ROLE_ID];
        $node_id = (int) $params[self::P_NODE_ID];

        $command = new BlockRoleCommand($role_id, $node_id);
        $command->run();
        if ($command->wasSuccessful()) {
            return true;
        } else {
            $this->error($command->getUnsuccessfulReason());
        }

        return true;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return "blockRole";
    }

    /**
     * @return array
     */
    protected function getAdditionalInputParams() : array
    {
        return [
            $this->param_factory->int(self::P_ROLE_ID),
            $this->param_factory->int(self::P_NODE_ID),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getOutputParams()
    {
        return ['success' => Base::TYPE_BOOL];
    }

    /**
     * @inheritdoc
     */
    public function getShortDocumentation()
    {
        return "Block a ILIAS Role (role_id) at the given node (node_id, e.g. a Course-Ref-ID)";
    }
}
