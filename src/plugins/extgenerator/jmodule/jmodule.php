<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_ROOT . '/components/com_extgenerator/libraries/plugin.php';

/**
 * Skyline Extension Generator Joomla Module Plugin
 *
 * @package		Skyline_ExtGenerator
 * @subpackage	Module
 */
class plgExtGeneratorJModule extends ExtGeneratorPlugin {

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct(&$subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);

		$this->_path	= __DIR__;
		$this->_extname	= array(
			'name'		=> 'jmodule',
			'full_name'	=> JText::_('PLG_EXTGENERATOR_JMODULE_FULL_NAME'),
		);
	}

	/**
	 * onCreateExtension hook.
	 *
	 * @param 	$data
	 * @return	bool
	 */
	function onCreateExtension($data) {
		if (!$this->canRun()) {
			return false;
		}
		require_once __DIR__ . '/forms/data.php';

		$data				= new ExtGeneratorDataJModule($data);
		if ($data->getError()) {
			return false;
		}

		return $data;
	}
}
