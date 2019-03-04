<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

jimport('joomla.form.formfield');

/**
 * Supports a extension select list.
 *
 * @package		Skyline_ExtGenerator
 * @subpackage	Fields
 * @since		1.6
 */
class JFormFieldExtension extends JFormField {
	/**
	 * The form field type.
	 * 
	 * @var string
	 */
	protected $type = 'extension';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 */
	protected function getInput() {
		require_once(JPATH_ROOT . '/components/com_extgenerator/libraries/factory.php');
		
		$dispatcher = ExtGeneratorFactory::getDispatcher();
		$result		= $dispatcher->trigger('onGetName', array(false));

		$select		= array(
			array(
				'name'		=> '',
				'full_name'	=> JText::_('COM_EXTGENERATOR_FIELD_SELECT_EXTENSION_SELECT'),
			),
		);
		$result		= array_merge($select, $result);

		if ($this->required) {
			$class = ' class="required"';
		}

		return JHtml::_('select.genericlist', $result, $this->name, $class, 'name', 'full_name', $this->value);
	}
}
