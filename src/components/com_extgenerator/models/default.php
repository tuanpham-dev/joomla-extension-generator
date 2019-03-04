<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.application.component.modelform');

/**
 * Skyline - Extension Generator Component Model
 *
 * @category	Skyline
 * @package		Skyline_ExtGenerator
 * @since		1.2
 */
class ExtGeneratorModelDefault extends JModelForm {
	protected $data		= null;

	/**
	 * Get Form.
	 *
	 * @param	array	$data
	 * @param	bool	$loadData
	 * @return	bool|JForm
	 */
	function getForm($data = array(), $loadData = true) {
		// get form
		$dispatcher	= ExtGeneratorFactory::getDispatcher();
		$dispatcher->trigger('onLoadForm', array($data, $loadData));

		$extension	= ExtGeneratorFactory::getExtension();
		$form		= $this->loadForm("com_extgenerator.$extension", $extension, array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Get data.
	 *
	 * @return	null
	 */
	public function getData() {
		if ($this->data === null) {
			$this->data	= new stdClass();
			$app		= JFactory::getApplication();

			// override the base data with any data in the session
			$extension	= ExtGeneratorFactory::getExtension();
			$temp		= (array) $app->getUserState("com_extgenerator.$extension.data", array());
			foreach ($temp as $k => $v) {
				$this->data->$k = $v;
			}
		}

		return $this->data;
	}

	/**
	 * Load Form Data.
	 *
	 * @return	null
	 */
	protected function loadFormData() {
		return $this->getData();
	}
}
