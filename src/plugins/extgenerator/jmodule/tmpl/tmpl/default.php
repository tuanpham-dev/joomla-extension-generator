<?php
/**
 * @copyright	Copyright (c) {{year}} {{namespaceN}}{{#website}} ({{website}}){{/website}}. All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

{{#assets}}JHtml::_('script', 'mod_{{prefix}}{{module}}/script.js', array(), true);
JHtml::_('stylesheet', 'mod_{{prefix}}{{module}}/style.css', array(), true);{{/assets}}
?>