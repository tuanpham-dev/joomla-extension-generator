<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

/**
 * @param	array	$query
 * @return	array
 */
function ExtGeneratorBuildRoute(&$query) {
	$segments	= array();

	// Get a menu item based on Itemid or currently active
	$app		= JFactory::getApplication();
	$menu		= $app->getMenu();
	$params		= JComponentHelper::getParams('com_extgenerator');
	$advanced	= $params->get('sef_advanced_link', 0);

	// We need a menu item. Either the one specified in the query, or the current active one if none specified
	if (empty($query['Itemid'])) {
		$menuItem		= $menu->getActive();
	} else {
		$menuItem		= $menu->getItem($query['Itemid']);
	}

	if (!isset($query['extension'])) {
		// We need to have a view in the query or it is an invalid URL
		return $segments;
	}

	if ($menuItem instanceof stdClass && isset($query['extension']) && $menuItem->query['extension'] == $query['extension']) {
		unset($query['extension']);

		if (isset($query['layout'])) {
			unset($query['layout']);
		}

		return $segments;
	}

	$segments[]	= $query['extension'];

	return $segments;
}

/**
 * @param	array	$segments
 * @return	array
 */
function ExtGeneratorParseRoute($segments)
{
	// initialise variables.
	$vars = array();

	$vars['view'] = 'default';

	// only run routine if there are segments to parse.
	if (count($segments) < 1) {
		return;
	}

	// get the package from the route segments.
	$extension = array_pop($segments);
	$vars['extension']	= $extension;

	return $vars;
}
