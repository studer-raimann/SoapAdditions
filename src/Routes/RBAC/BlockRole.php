<?php

namespace srag\Plugins\SoapAdditions\Routes\RBAC;

use ilSoapPluginException;
use srag\Plugins\SoapAdditions\Base;
use srag\Plugins\SoapAdditions\Command\RBAC\BlockRole as BlockRoleCommand;

/**
 * Class BlockRole
 *
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class BlockRole extends Base {

	const P_ROLE_ID = 'role_id';
	const P_NODE_ID = 'node_id';


	/**
	 * @param array $params
	 *
	 * @return bool|mixed
	 * @throws ilSoapPluginException
	 */
	protected function run(array $params) {
		$role_id = (int)$params[self::P_ROLE_ID];
		$node_id = (int)$params[self::P_NODE_ID];

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
	public function getName() {
		return "blockRole";
	}


	/**
	 * @return array
	 */
	protected function getAdditionalInputParams() {
		return array(self::P_ROLE_ID => Base::TYPE_INT, self::P_NODE_ID => Base::TYPE_INT);
	}


	/**
	 * @inheritdoc
	 */
	public function getOutputParams() {
		return ['success' => Base::TYPE_BOOL];
	}


	/**
	 * @inheritdoc
	 */
	public function getDocumentation() {
		return "Block a ILIAS Role (role_id) at the given node (node_id, e.g. a Course-Ref-ID)";
	}
}
