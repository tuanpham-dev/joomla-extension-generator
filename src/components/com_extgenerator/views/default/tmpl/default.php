<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<div class="page-header">
	<h2><?php echo JText::_('COM_EXTGENERATOR_' . $this->extension_name); ?></h2>
</div>

<form action="<?php echo JRoute::_('index.php?option=com_extgenerator&extension=' . $this->extension_name . '&Itemid=' . $this->itemId); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal extgen-form">
	<fieldset>
		<?php echo $this->body; ?>
	</fieldset>

	<div class="form-actions">
		<input type="submit" name="submit" class="btn btn-large btn-success validate" value="<?php echo JText::_('COM_EXTGENERATOR_CREATE'); ?>" accesskey="c" />
	</div>

	<input type="hidden" name="option" value="com_extgenerator" />
	<input type="hidden" name="extension" value="<?php echo $this->extension_name; ?>" />
	<input type="hidden" name="Itemid" value="<?php echo $this->itemId; ?>" />
	<input type="hidden" name="task" value="create" />
	<?php echo JHTML::_('form.token'); ?>
</form>
