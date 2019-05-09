<?php

namespace srag\Plugins\SoapAdditions;

/**
 * Class BlockRole
 *
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
class BlockRole extends Base {

	/**
	 * @param array $params
	 *
	 * @return bool
	 */
	protected function run(array $params) {
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
		return array();
	}


	/**
	 * @inheritdoc
	 */
	public function getOutputParams() {
		return array('role_id' => Base::TYPE_INT_ARRAY, 'node_id' => Base::TYPE_INT_ARRAY);
	}


	/**
	 * @inheritdoc
	 */
	public function getDocumentation() {
		return "Block a ILIAS Role at the given node";
	}
}
