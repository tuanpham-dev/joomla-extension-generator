<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

/**
 * Skyline - Extension Generator Component Factory
 *
 * @category	Skyline
 * @package		Skyline_ExtGenerator
 * @since		1.2
 */
class ExtGeneratorFactory {
	private static $_logs		= array();
	private static $_extName	= null;
	private static $_extension	= null;

	/**
	 * Get extension.
	 *
	 * @static
	 * @return	string
	 */
	static function &getExtension() {
		return self::$_extension;
	}

	/**
	 * Get logs.
	 * 
	 * @static
	 * @return	array
	 */
	static function &getLogs() {
		return self::$_logs;
	}

	/**
	 * Get extension name.
	 *
	 * @static
	 * @return	string
	 */
	static function &getExtName() {
		return self::$_extName;
	}

	/**
	 * Get dispatcher.
	 *
	 * @static
	 * @return	JDispatcher
	 */
	static function getDispatcher() {
		JPluginHelper::importPlugin('extgenerator');
		$dispatcher		= JDispatcher::getInstance();

		return $dispatcher;
	}


	/**
	 * Get parser instance.
	 *
	 * @static
	 * @return	Mustache_Engine
	 */
	static function getParser() {
		static $instance;

		if (!is_object($instance)) {
			$instance	= new Mustache_Engine();
		}

		return $instance;
	}
}
