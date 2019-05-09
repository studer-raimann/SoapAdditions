<?php

namespace srag\Plugins\SoapAdditions\RBAC;

use Exception;
use ilObject2;
use ilSoapPluginException;
use srag\Plugins\SoapAdditions\Base;

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

		// Checks //
		// Check if is role
		if (!$this->isRole($role_id)) {
			$this->error("$role_id is not a role");

			return false;
		}
		// Check if is node
		if (!$this->isNode($node_id)) {
			$this->error("$node_id is not a node");

			return false;
		}

		if (!$this->blockRole($role_id, $node_id)) {
			$this->error("an unknown error has occured during blocking the role.");

			return false;
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


	/**
	 * @param $role_id
	 * @param $node_id
	 *
	 * @return bool
	 */
	private function blockRole(/*int*/ $role_id, /*int*/ $node_id)/*:bool*/ {
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
			return false;
		}

		return true;
	}


	/**
	 * @param int $role_id
	 *
	 * @return bool
	 */
	private function isRole(/*int*/ $role_id)/*:bool*/ {
		return (bool)(ilObject2::_exists($role_id, false) && ilObject2::_lookupType($role_id, false) === "role");
	}


	/**
	 * @param int $node_id
	 *
	 * @return bool
	 */
	private function isNode(/*int*/ $node_id)/*:bool*/ {
		return (bool)(ilObject2::_exists($node_id, true));
	}
}
