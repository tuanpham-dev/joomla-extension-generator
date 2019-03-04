<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

// require the libraries
require_once(JPATH_COMPONENT . '/libraries/factory.php');
require_once(JPATH_COMPONENT . '/libraries/helper.php');

// save current extension
$extension	= &ExtGeneratorFactory::getExtension();
$extension	= JFactory::getApplication()->input->getString('extension');

// add script and stylesheet
$live_site	= JURI::root(true);
$document	= JFactory::getDocument();

JHtml::_('stylesheet', 'com_extgenerator/style.css', false, true, false, false, true);
JHtml::_('stylesheet', 'com_extgenerator/jquery.msgbox.css', false, true, false, false, true);

JHtml::_('jquery.framework');
JHtml::_('script', 'jui/jquery.ui.core.js', false, true, false, false, true);
JHtml::_('script', 'jui/jquery.ui.sortable.js', false, true, false, false, true);
Jhtml::_('script', 'com_extgenerator/jquery.msgbox.min.js', false, true, false, false, true);
Jhtml::_('script', 'com_extgenerator/script.js', false, true, false, false, true);

// create the controller
$controller = JControllerLegacy::getInstance('ExtGenerator');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
