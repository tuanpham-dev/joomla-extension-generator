<?php
/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

// no direct access
defined('_JEXEC') or die();

$document	= JFactory::getDocument();
$link		= JRoute::_('index.php?option=com_extgenerator&task=download&extension=' . $this->extension_name . '&name=' . $this->ext_name, false);
$js			= "
jQuery(function() {
	setTimeout('ExtStore.ExtGenerator.download(\'$link\')', 2000);
});
";
$document->addScriptDeclaration($js);
?>

<div id="extgen-msg">
	<div class="alert alert-success">
		<a href="#" class="close" data-dismiss="alert">&times;</a>
		<?php echo JText::sprintf('COM_EXTGENERATOR_EXTENSION_CREATE_SUCCESS', $link); ?>
	</div>
	<h4>
		<?php echo JText::_('COM_EXTGENERATOR_FILE_LOGS_MSG'); ?>
	</h4>
	<div class="alert alert-info">
		<ul>
			<?php foreach ($this->logs as $log) : ?>
			<li>
				<?php echo $log; ?>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
