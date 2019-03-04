<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

/**
 * Abstract class for plugin data.
 */
abstract class ExtGeneratorData {
	/** @var string */
	protected $_extname		= '';
	/** @var string */
	protected $_tmpl_path	= '';
	/** @var array */
	protected $_files		= array();
	/** @var bool */
	protected $_error		= false;

	/**
	 * Get extension name.
	 *
	 * @return string
	 */
	public function getExtName() {
		return $this->_extname;
	}

	/**
	 * Get template path.
	 *
	 * @return string
	 */
	public function getTemplatePath() {
		return $this->_tmpl_path;
	}

	/**
	 * Get error.
	 *
	 * @return bool
	 */
	public function getError() {
		return $this->_error;
	}

	/**
	 * Method to get files.
	 *
	 * @return array
	 */
	public function getFiles() {
		return $this->_files;
	}

	/**
	 * Add file.
	 *
	 * @param	string	$source
	 * @param	string	$destination
	 * @param	string	$group
	 */
	protected function addFile($source, $destination, $group = '') {
		$this->_files[]	= array(
			'source' 		=> $source,
			'destination'	=> $destination,
			'group'			=> $group
		);
	}

	protected function getString($string) {
		return preg_replace("/[^A-Za-z0-9 ]/", '', $string);
	}

	protected function getName($string) {
		return str_replace('  ', ' ', $this->getString($string));
	}

	protected function getCamelCase($string) {
		return str_replace(' ', '', $this->getString($string));
	}

	protected function getLowerCase($string) {
		return strtolower($this->getCamelCase($string));
	}

	protected function getUpperCase($string) {
		return strtoupper($this->getCamelCase($string));
	}

	protected function getArray($string, $result = array()) {
		$array		= explode('|', $string);

		foreach ($array as $a) {
			$arr	= explode(':', $a);

			if (!count($arr)) {
				continue;
			} else if (count($arr) == 1) {
				$value	= $this->getName($arr[0]);
			} else {
				$value	= $this->getName($arr[1]);
			}

			$result	= array_merge($result, array($this->getLowerCase($arr[0]) => $value));
		}

		return $result;
	}

	protected function getIterableArray($string) {
		$result		= array();
		$array		= explode('|', $string);

		foreach ($array as $a) {
			$arr	= explode(':', $a);

			if (!count($arr)) {
				continue;
			} else if (count($arr) == 1) {
				$value	= $this->getName($arr[0]);
			} else {
				$value	= $this->getName($arr[1]);
			}

			$result[]	= array(
				'key'	=> $this->getLowerCase($arr[0]),
				'keyU'	=> $this->getUpperCase($arr[0]),
				'val'	=> $value,
			);
		}

		return $result;
	}

	public function month() {
		return JFactory::getDate()->format('F');
	}

	public function year() {
		return JFactory::getDate()->format('Y');
	}
}
