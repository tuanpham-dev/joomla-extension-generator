<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die;

$document = JFactory::getDocument();
$document->addScript(JURI::root(true) . '/plugins/extgenerator/jplugin/forms/jplugin.js');
?>

<div class="control-group">
	<div class="control-label">
		<?php echo $form->getLabel('name'); ?>
	</div>
	<div class="controls">
		<?php echo $form->getInput('name'); ?>
	</div>
</div>
<div class="control-group">
	<div class="control-label">
		<?php echo $form->getLabel('group'); ?>
	</div>
	<div class="controls">
		<?php echo $form->getInput('group'); ?>
	</div>
</div>
<div class="control-group">
	<div class="control-label">
		<?php echo $form->getLabel('namespace'); ?>
	</div>
	<div class="controls">
		<?php echo $form->getInput('namespace'); ?>
	</div>
</div>
<div class="control-group">
	<div class="control-label">
		<?php echo $form->getLabel('author'); ?>
	</div>
	<div class="controls">
		<?php echo $form->getInput('author'); ?>
	</div>
</div>
<div class="control-group">
	<div class="control-label">
		<?php echo $form->getLabel('description'); ?>
	</div>
	<div class="controls">
		<?php echo $form->getInput('description'); ?>
	</div>
</div>
