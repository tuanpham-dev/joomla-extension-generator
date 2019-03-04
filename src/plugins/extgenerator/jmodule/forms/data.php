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
class ExtGeneratorDataJModule extends ExtGeneratorData {
	public $module			= '';
	public $moduleC			= '';
	public $moduleU			= '';
	public $moduleN			= '';
	public $assets			= '';
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
		$module_data	= explode(',', $data['name']);
		$moduleNS		= $this->getName($module_data[0]);

		if (empty($moduleNS)) {
			$this->_error = true;
			return;
		}

		if (isset($module_data[1]) && trim($module_data[1])) {
			$this->moduleN	= $this->getName($module_data[1]);
		} else {
			$this->moduleN	= $moduleNS;
		}

		if (isset($module_data[2]) && trim($module_data[2])) {
			$this->assets	= '1';
		}

		$this->module	= $this->getLowerCase($moduleNS);
		$this->moduleC	= $this->getCamelCase($moduleNS);
		$this->moduleU	= $this->getUpperCase($moduleNS);

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
		$this->authorN	= $this->getName($author_data[0]);

		if (isset($author_data[1]) && trim($author_data[1])) {
			$this->email	= $this->getLowerCase($author_data[1]);
		}

		// process description
		$this->descriptionN	= str_replace(array("\n", '    ', '{{extname}}'), array("\n\t\t", "\t", $this->namespaceC . ' ' . $this->moduleN), $this->getName($data['description']));

		// process extension name && template path
		$this->_extname		= 'mod_' . $this->prefix . $this->module;
		$this->_tmpl_path	= JPATH_PLUGINS . '/extgenerator/jmodule/tmpl/';

		// generate files
		$this->addFile('module.xml',			"mod_{$this->prefix}{$this->module}.xml");
		$this->addFile('module.php',			"mod_{$this->prefix}{$this->module}.php");
		$this->addFile('helper.php',			"helper.php");
		$this->addFile('en-GB.module.ini',		"en-GB.mod_{$this->prefix}{$this->module}.ini");
		$this->addFile('en-GB.module.sys.ini',	"en-GB.mod_{$this->prefix}{$this->module}.sys.ini");
		$this->addFile('tmpl/default.php',		"tmpl/default.php");

		if ($this->assets) {
			$this->addFile('media/css/style.css',	'media/css/style.css');
			$this->addFile('media/js/script.js',	'media/js/script.js');
		}
	}
}
