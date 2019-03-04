<?php
/**
 * @copyright	Copyright (c) {{year}} {{namespaceN}}{{#website}} ({{website}}){{/website}}. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * {{groupN}} - {{pluginN}} Plugin
 *
 * @package		Joomla.Plugin
 * @subpakage	{{namespaceC}}.{{pluginC}}
 */
class plg{{groupC}}{{prefixU}}{{pluginC}} extends JPlugin {

	/**
	 * Constructor.
	 *
	 * @param 	$subject
	 * @param	array $config
	 */
	function __construct(&$subject, $config = array()) {
		// call parent constructor
		parent::__construct($subject, $config);
	}
	
}