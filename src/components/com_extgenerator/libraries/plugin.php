<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.plugin.plugin');

class ExtGeneratorPlugin extends JPlugin {
	protected $_extname	= array(
		'name'		=> '',
		'full_name'	=> '',
	);

	protected $_path	= '';

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct(&$subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);
		// load language
		$this->loadLanguage();
	}

	/**
	 * Get extension name.
	 *
	 * @return array
	 */
	function getName() {
		return $this->_extname;
	}

	/**
	 * Check if this plugin can be run.
	 *
	 * @return bool
	 */
	function canRun() {
		$factory = JPATH_ROOT . '/components/com_extgenerator/libraries/factory.php';
		if (file_exists($factory)) {
			require_once($factory);

			if (class_exists('ExtGeneratorFactory')) {
				return $this->isActive();
			}
		}

		return false;
	}

	/**
	 * Check if plugin is active.
	 *
	 * @return bool
	 */
	function isActive() {
		$extension	= ExtGeneratorFactory::getExtension();
		$name		= $this->getName();

		return $name['name'] == $extension;
	}

	/**
	 * onGetName hook.
	 *
	 * @param	bool	$checkActive
	 * @return	bool|array
	 */
	function onGetName($checkActive = true) {
		if ($checkActive && !$this->canRun()) {
			return false;
		}

		return $this->getName();
	}

	/**
	 * onLoadForm hook.
	 *
	 * @return	bool
	 */
	function onLoadForm() {
		if (!$this->canRun()) {
			return false;
		}

		JForm::addFormPath($this->_path . '/forms');
	}

	/**
	 * onGetFormBody hook.
	 *
	 * @param 	$form
	 * @param 	$data
	 * @return	bool|string
	 */
	function onGetFormBody($form, $data) {
		if (!$this->canRun()) {
			return false;
		}
		ob_start();
		require_once($this->_path . '/forms/body.php');
		$body = ob_get_contents();
		ob_end_clean();

		return $body;
	}

	/**
	 * onCreateExtension hook.
	 *
	 * @param 	$data
	 * @param	$tmp_path
	 * @return	bool
	 */
	function onCreateExtension($data) {
		return true;
	}
}
