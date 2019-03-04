<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');

/**
 * Skyline - Extension Generator Component Helper
 *
 * @category	Skyline
 * @package		Skyline_ExtGenerator
 * @since		1.2
 */
class ExtGeneratorHelper {

	/**
	 * Get result of plugin.
	 *
	 * @static
	 * @param	array	$array
	 * @return	bool
	 */
	static function getPluginResult($array) {
		if (is_array($array)) {
			foreach ($array as $result) {
				if ($result !== false) {
					return $result;
				}
			}

			return false;
		} else {
			return $array;
		}
	}

	/**
	 * Create file from template.
	 *
	 * @static
	 * @param	string	$tmpl		Template file path
	 * @param	string	$new		New file path
	 * @param	array	$search		Search array
	 * @param	array	$replace	Replace array
	 * @param	bool	$group		Group
	 * @return	bool
	 */
	static function create($data, $tmpl, $new, $group = false) {
		if (!JFile::exists($tmpl)) {
			return false;
		}

		// make the directory if it doesn't exist
		$dir = dirname($new);
		if (!is_dir($dir)) {
			JFolder::create($dir, 0777);
		}

		// load template file
		$contents	= JFile::read($tmpl);

		// write new file
		if (!preg_match('#(.png)|(.jpg)|(.jpeg)|(.gif)|(index.html)$#', $new)) {
			if ($group) {
				$contents	= str_replace('{group}', $group, $contents);
			}

			$contents	= ExtGeneratorFactory::getParser()->render($contents, $data);
		}

		JFile::write($new, $contents);

		return true;
	}

	/**
	 * Write files.
	 * 
	 * @static
	 * @param	ExtGeneratorData	$data
	 * @param	string	$tmpl_path
	 * @param	string	$ext_path
	 * @return	void
	 */
	static function write($data, $tmpl_path, $ext_path) {
		// require mustache libraries
		require_once(dirname(__FILE__) . '/Mustache/Autoloader.php');
		Mustache_Autoloader::register();

		// delete the old folder
		if (is_dir($ext_path)) {
			 JFolder::delete($ext_path);
		}

		$logs	= &ExtGeneratorFactory::getLogs();

		foreach ($data->getFiles() as $file) {
			if (!self::create($data, $tmpl_path . $file['source'], $ext_path . '/' . $file['destination'], $file['group'])) {
				JError::raiseError(500, JText::sprintf('COM_EXTGENERATOR_CREATE_FILE_ERROR', $file['source']));
			}
			
			$logs[] = $file['destination'];
		}
	}

	/**
	 * Compress a folder.
	 *
	 * @static
	 * @param	string	$file_name
	 * @param	string	$folder
	 * @param	bool	$include
	 * @return	void
	 */
	static function createZip($file_name, $folder, $include = true) {
		$zip = new ZipArchive();

		if ($zip->open($file_name, ZipArchive::CREATE) !== true) {
			JError::raiseError(500, JText::_('COM_EXTGENERATOR_CREATE_ZIP_ERROR'));
		}

		$iterator	= new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));

		foreach ($iterator as $key => $value) {
			$key2 = substr($key, strlen($folder) + 1);
			
			if (basename($key) == '.' || basename($key) == '..') {
				continue;
			}
			
			if (!$zip->addFile(realpath($key), $key2)) {
				JError::raiseError(500, JText::_('COM_EXTGENERATOR_ADD_FILE_ERROR'));
			}
		}

		$zip->close();
	}

	/**
	 * Download a zip file.
	 *
	 * @static
	 * @param	string	$file_name
	 * @return	void
	 */
	static function download($file_name) {
		if (!file_exists($file_name) || !is_file($file_name)) {
			JError::raiseError(404, JText::_('COM_EXTGENERATOR_FILE_NOT_FOUND'));
		}

		// required for IE, otherwise content-disposition is igrnored
		if (ini_get('zlib.output_compression')) {
			ini_set('zlib.output_compression', 'Off');
		}

		while (@ob_end_clean());

		header("Pragma: no-cache"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false); // required for certain browsers
		header("Content-Type: application/zip");
		header("Content-Disposition: attachment; filename=" . basename($file_name).";" );
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . @filesize($file_name));

		self::readFileChunked($file_name);
		jexit();
	}

	/**
	 * Read file.
	 *
	 * @static
	 * @param	string	$file_name
	 * @param	bool $report
	 * @return	bool|int
	 */
	static function readFileChunked($file_name, $report = false) {
		$chunk_size	= 1024 * 1024; // how many bytes per chunk
		$buffer		= '';
		$count		= 0;
		$handle		= fopen($file_name, 'rb');

		if ($handle == false) {
			return false;
		}

		while (!feof($handle)) {
			$buffer		= fread($handle, $chunk_size);
			echo $buffer;
			@ob_flush();
			flush();
			if ($report) {
				$count += strlen($buffer);
			}
		}

		$status = fclose($handle);
		if ($report && $status) {
			return $count;
		}

		return $status;
	}
}
