/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

ExtStore.ExtGenerator.JPlugin = {
	options:	null,
	id:			0,

	init: function() {
		ExtStore.ExtGenerator.addDetails('#jform_name', ExtStore.ExtGenerator.JPlugin.nameField);
		ExtStore.ExtGenerator.addDetails('#jform_group', ExtStore.ExtGenerator.JPlugin.groupField);
		ExtStore.ExtGenerator.addDetails('#jform_namespace', ExtStore.ExtGenerator.JPlugin.namespaceField);
		ExtStore.ExtGenerator.addDetails('#jform_author', ExtStore.ExtGenerator.JPlugin.authorField);
	},

	nameField: function(el) {
		var values	= jQuery(el).val().split(/,\s*/);

		jQuery.msgbox('', {
			type: 'prompt',
			inputs  : [
      			{
					type:		'text',
					label:		'Plugin Name:',
					value:		values[0] ? values[0] : '',
					required:	true
				},
				{
					type:		'text',
					label:		'Plugin Display Name:',
					value:		values[1] ? values[1] : '',
					required:	false
				},
				{
					type:		'text',
					label:		'Include Media Into Plugin:',
					value:		values[2] ? values[2] : '',
					required:	false
				}
			]
		}, function() {
			ExtStore.ExtGenerator.updateValues(el, arguments);
		});
	},

	groupField: function(el) {
		var values	= jQuery(el).val().split(/,\s*/);

		jQuery.msgbox('', {
			type: 'prompt',
			inputs  : [
      			{
					type:		'text',
					label:		'Group Name:',
					value:		values[0] ? values[0] : '',
					required:	true
				},
				{
					type:		'text',
					label:		'Group Display Name:',
					value:		values[1] ? values[1] : '',
					required:	false
				}
			]
		}, function() {
			ExtStore.ExtGenerator.updateValues(el, arguments);
		});
	},

	namespaceField: function(el) {
		var values	= jQuery(el).val().split(/,\s*/);

		jQuery.msgbox('', {
			type: 'prompt',
			inputs  : [
      			{
					type:		'text',
					label:		'Namespace:',
					value:		values[0] ? values[0] : '',
					required:	true
				},
				{
					type:		'text',
					label:		'Company Name:',
					value:		values[1] ? values[1] : '',
					required:	false
				},
				{
					type:		'text',
					label:		'Website URL:',
					value:		values[2] ? values[2] : '',
					required:	false
				},
				{
					type:		'text',
					label:		'Prefix',
					value:		values[3] ? values[3] : '',
					required:	false
				}
			]
		}, function() {
			ExtStore.ExtGenerator.updateValues(el, arguments);
		});
	},

	authorField: function(el) {
		var values	= jQuery(el).val().split(/,\s*/);

		jQuery.msgbox('', {
			type: 'prompt',
			inputs  : [
      			{
					type:		'text',
					label:		'Author Name:',
					value:		values[0] ? values[0] : '',
					required:	true
				},
				{
					type:		'text',
					label:		'Author E-mail:',
					value:		values[1] ? values[1] : '',
					required:	false
				}
			]
		}, function() {
			ExtStore.ExtGenerator.updateValues(el, arguments);
		});
	}
}

jQuery(function() {
	ExtStore.ExtGenerator.JPlugin.init();
});
