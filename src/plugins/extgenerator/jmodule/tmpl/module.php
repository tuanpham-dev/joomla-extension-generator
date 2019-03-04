<?php
/**
 * @copyright	@copyright	Copyright (c) {{year}} {{namespaceN}}{{#website}} ({{website}}){{/website}}. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

// include the syndicate functions only once
require_once __DIR__ . '/helper.php';


$class_sfx = htmlspecialchars($params->get('class_sfx'));

require(JModuleHelper::getLayoutPath('mod_{{prefix}}{{module}}', $params->get('layout', 'default')));