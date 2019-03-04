<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

/**
 * Skyline - Extension Generator Component Controller
 *
 * @category	Skyline
 * @package		Skyline_ExtGenerator
 * @since		1.2
 */
class ExtGeneratorController extends JControllerLegacy {
	var $default_view	= 'default';

	/**
	 * Constructor.
	 */
	function __construct() {
		// call parent constructor
		parent::__construct();
	}

	/**
	 * Create action.
	 *
	 * @return void
	 */
	function create() {
		// check for request forgeries.
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// initialise variables
		$app		= JFactory::getApplication();
		$extension	= ExtGeneratorFactory::getExtension();
		$context	= 'com_extgenerator.create.' . $extension . '.';
		$Itemid		= $this->input->getInt('Itemid');
		$itemId		= $Itemid ? '&Itemid=' . $Itemid : '';
		/** @var $model JModelForm */
		$model		= $this->getModel();
		$form		= $model->getForm();

		if (!$form) {
			JError::raiseError(500, $model->getError());
			return false;
		}

		// get posted form variables
		$data		= $this->input->post->get('jform', array(), 'array');

		// validate the posted data
		$data		= $model->validate($form, $data);

		// check for validation errors
		if ($data === false) {
			// get the validatioin messages
			$errors	= $model->getErrors();

			// push up the three validation messages out to the user
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if (JError::isError($errors[$i])) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'notice');
				} else {
					$app->enqueueMessage($errors[$i], 'notice');
				}
			}

			// save the data in the session
			$app->setUserState($context . 'data', $data);

			// redirect back to the screen edit
			$this->setRedirect(JRoute::_('index.php?option=com_extgenerator&extension=' . $extension . $itemId, false));
			return false;
		}

		$tmp_path		= JFactory::getConfig()->get('tmp_path') . '/' . $extension;

		$dispatcher		= ExtGeneratorFactory::getDispatcher();
		$result			= $dispatcher->trigger('onCreateExtension', array($data));
		$result			= ExtGeneratorHelper::getPluginResult($result);

		if (!$result) {
			// redirect back to the screen edit
			$this->setRedirect(JRoute::_('index.php?option=com_extgenerator&extension=' . $extension . $itemId, false));
			return false;
		} else {
			$extName	= &ExtGeneratorFactory::getExtName();
			$extName	= $result->getExtName();
			ExtGeneratorHelper::write($result, $result->getTemplatePath(), $tmp_path . '/' . $extName);

			// flush the data from the session
			$app->setUserState($context . 'data', null);

			$this->input->set('view', 'default');
			$this->input->set('layout', 'message');
			parent::display();
		}
	}

	/**
	 * Download.
	 *
	 * @return void
	 */
	public function download() {
		jimport('joomla.filesystem.file');

		$name		= strtolower($this->input->getString('name'));
		$extension	= ExtGeneratorFactory::getExtension();
		$name		= JFile::makeSafe($name);
		$extension	= JFile::makeSafe($extension);
		//$path		= JPATH_COMPONENT.DS.'assets'.DS.'tmp'.DS.$extension.DS;
		$path		= JFactory::getConfig()->get('tmp_path') . '/' . $extension . '/';


		if (!is_dir($path.$name)) {
			JError::raiseError(404, JText::_('COM_EXTGENERATOR_EXTENSION_NOT_FOUND'));
		}

		// delete the old file
		$folder_path	= $path.$name;
		$file_path		= $folder_path.'.zip';
		if (file_exists($file_path)) {
			unlink($file_path);
		}

		ExtGeneratorHelper::createZip($file_path, $folder_path, false);
		ExtGeneratorHelper::download($file_path);
	}

	/**
	 * Get model object, loading it if required.
	 *
	 * @param string $name
	 * @param string $prefix
	 * @param array $config
	 * @return object
	 */
	function &getModel($name = 'default', $prefix = '', $config = array()) {
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}
