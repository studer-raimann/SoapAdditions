<?php
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilSoapAdditionsPlugin
 */
class ilSoapAdditionsPlugin extends ilSoapHookPlugin {

	const PLUGIN_NAME = 'SoapAdditions';


	/**
	 * @return string
	 */
	public function getPluginName() {
		return self::PLUGIN_NAME;
	}


	/**
	 * @inheritdoc
	 */
	public function getSoapMethods() {
		return array();
	}


	/**
	 * @inheritdoc
	 */
	public function getWsdlTypes() {
		return array();
	}
}