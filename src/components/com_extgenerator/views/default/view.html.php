<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.application.component.view');

/**
 * Skyline - Extension Generator Component View
 *
 * @category	Skyline
 * @package		Skyline_ExtGenerator
 * @since		1.2
 */
class ExtGeneratorViewDefault extends JViewLegacy {
	/**
	 * Display.
	 * 
	 * @param	string $tpl
	 * @return	void
	 */
	function display($tpl = null) {
		// initialize variables
		$app		= JFactory::getApplication();
		$user		= JFactory::getUser();


		$authorised	= $user->authorise('extension.create', 'com_extgenerator');
		if ($authorised !== true) {
			JError::raiseError(403, JText::_('JERROR_ALERTNOAUTHOR'));

			return false;
		}

		if ($this->getLayout() == 'message') {
			$this->_displayMessage($tpl);
		} else {
			$this->data		= $this->get('Data');
			$this->form		= $this->get('Form');

			//
			$dispatcher		= ExtGeneratorFactory::getDispatcher();
			$result			= $dispatcher->trigger('onGetFormBody', array($this->form, $this->data));
			$this->body		= ExtGeneratorHelper::getPluginResult($result);
		}

		$dispatcher		= ExtGeneratorFactory::getDispatcher();
		$result			= $dispatcher->trigger('onGetName');
		$extension		= ExtGeneratorHelper::getPluginResult($result);

		$this->extension_name		= isset($extension['name']) ? $extension['name'] : '';
		$this->extension_full_name	= isset($extension['full_name']) ? $extension['full_name'] : '';
		$this->itemId				= JFactory::getApplication()->input->get('Itemid');
		$this->params				= $app->getParams();

		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Display Message.
	 *
	 * @param	string	$tpl
	 * @return	void
	 */
	private function _displayMessage($tpl) {
		// get the logs
		$this->logs		= ExtGeneratorFactory::getLogs();
		// get extension name
		$this->ext_name	= ExtGeneratorFactory::getExtName();
	}

	/**
	 * Prepare Document.
	 * 
	 * @return void
	 */
	protected function _prepareDocument() {
		$app		= JFactory::getApplication();
		$menus		= $app->getMenu();
		$title		= null;

		// because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu	= $menus->getActive();

		if ($menu) {
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		} else {
			$this->params->def('page_heading', JText::_('COM_GENERATOR_DEFAULT_TITLE'));
		}

		$title = $this->params->get('page_title', '');

		if ($menu && ($menu->query['option'] != 'com_extgenerator' || $menu->query['view'] != 'default')) {
			if ($this->extension_full_name) {
				$title	= JText::sprintf('COM_EXTGENERATOR_CREATE_NEW_EXTENSION', $this->extension_full_name);
			} else {
				$title	= JText::_('COM_EXTGENERATOR_DEFAULT_TITLE');
			}
		}

		if (empty($title)) {
			$title = $app->get('sitename');
		} else if ($app->get('sitename_pagetitles', 0) == 1) {
			$title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		} else if ($app->get('sitename_pagetitles', 0) == 2) {
			$title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description')) {
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords')) {
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots')) {
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
	}
}
