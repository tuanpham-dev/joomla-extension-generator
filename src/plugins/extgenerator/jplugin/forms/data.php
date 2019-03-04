<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_ROOT . '/components/com_extgenerator/libraries/data.php';

/**
 * Data class.
 */
class ExtGeneratorDataJPlugin extends ExtGeneratorData {
	public $plugin			= '';
	public $pluginC			= '';
	public $pluginU			= '';
	public $pluginN			= '';
	public $assets			= '';
	public $group			= '';
	public $groupC			= '';
	public $groupU			= '';
	public $groupN			= '';
	public $namespaceC		= '';
	public $namespaceN		= '';
	public $website			= '';
	public $prefix			= '';
	public $prefixU			= '';
	public $authorN			= '';
	public $email			= '';
	public $descriptionN	= '';

	public function __construct($data) {

		// process name
		$plugin_data	= explode(',', $data['name']);
		$pluginNS		= $this->getName($plugin_data[0]);

		if (empty($pluginNS)) {
			$this->_error = true;
			return;
		}

		if (isset($plugin_data[1]) && trim($plugin_data[1])) {
			$this->pluginN	= $this->getName($plugin_data[1]);
		} else {
			$this->pluginN	= $pluginNS;
		}

		if (isset($plugin_data[2]) && trim($plugin_data[2])) {
			$this->assets	= '1';
		}

		$this->plugin	= $this->getLowerCase($pluginNS);
		$this->pluginC	= $this->getCamelCase($pluginNS);
		$this->pluginU	= $this->getUpperCase($pluginNS);

		// process group
		$group_data		= explode(',', $data['group']);
		$groupSN		= $this->getName($group_data[0]);

		if (isset($group_data[1]) && trim($group_data[1])) {
			$this->groupN	= $this->getName($group_data[1]);
		} else {
			$this->groupN	= $groupSN;
		}

		$this->group	= $this->getLowerCase($groupSN);
		$this->groupC	= $this->getCamelCase($groupSN);
		$this->groupU	= $this->getUpperCase($groupSN);

		// process namespace
		$namespace_data		= explode(',', $data['namespace']);
		$namespaceSN		= $this->getName($namespace_data[0]);
		$this->namespaceC	= $this->getCamelCase($namespaceSN);

		if (isset($namespace_data[1]) && trim($namespace_data[1])) {
			$this->namespaceN	= $this->getName($namespace_data[1]);
		} else {
			$this->namespaceN	= $namespaceSN;
		}

		if (isset($namespace_data[2]) && trim($namespace_data[2])) {
			$this->website	= $this->getLowerCase($namespace_data[2]);
		}

		if (isset($namespace_data[3]) && trim($namespace_data[3])) {
			$this->prefix	= $this->getLowerCase($namespace_data[3]);
			$this->prefixU	= $this->getUpperCase($namespace_data[3]);
		}

		// process author
		$author_data	= explode(',', $data['author']);
		$this->author	= $this->getName($author_data[0]);

		if (isset($author_data[1]) && trim($author_data[1])) {
			$this->email	= $this->getLowerCase($author_data[1]);
		}

		// process description
		$this->descriptionN	= str_replace(array("\n", '    ', '{{extname}}'), array("\n\t\t", "\t", $this->namespaceC . ' ' . $this->pluginN), $this->getName($data['description']));

		// process extension name && template path
		$this->_extname		= 'plg_' . $this->group  . '_' . $this->prefix . $this->plugin;
		$this->_tmpl_path	= JPATH_PLUGINS . '/extgenerator/jplugin/tmpl/';

		// generate files
		$this->addFile('plugin.xml',			"{$this->prefix}{$this->plugin}.xml");
		$this->addFile('plugin.php',			"{$this->prefix}{$this->plugin}.php");
		$this->addFile('en-GB.plugin.ini',		"en-GB.plg_{$this->group}_{$this->prefix}{$this->plugin}.ini");
		$this->addFile('en-GB.plugin.sys.ini',	"en-GB.plg_{$this->group}_{$this->prefix}{$this->plugin}.sys.ini");

		if ($this->assets) {
			$this->addFile('media/css/style.css',	'media/css/style.css');
			$this->addFile('media/js/script.js',	'media/js/script.js');
		}
	}
}
