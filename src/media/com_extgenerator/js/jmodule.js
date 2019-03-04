/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

ExtStore.ExtGenerator.JModule = {
	options:	null,
	id:			0,

	init: function() {
		ExtStore.ExtGenerator.JModule.addDetails('#jform_name', ExtStore.ExtGenerator.JModule.nameField);
		ExtStore.ExtGenerator.JModule.addDetails('#jform_namespace', ExtStore.ExtGenerator.JModule.namespaceField);
		ExtStore.ExtGenerator.JModule.addDetails('#jform_author', ExtStore.ExtGenerator.JModule.authorField);
	},

	addDetails: function(el, callback) {
		if (!(jQuery.browser.msie  && parseInt(jQuery.browser.version) == 7)) {
			jQuery(el).css('padding-right', '25px');
		}

		var detail	= jQuery('<span type="button" class="fieldDetails" />').insertAfter(jQuery(el));

		if (jQuery.isFunction(callback)) {
			detail.click(function() {
				callback(el);
			});
		}
	},

	updateValues: function(el, args) {
		if (!args.length || args[0] == false) {
			return false;
		}

		var value	= '';

		for (var i = args.length - 1; i > 0; i--) {
			if (args[i] || value) {
				value = ', ' + args[i] + value;
			}
		}
		value	= args[0] + value;

		jQuery(el).val(value);
		jQuery(el).focus();
	},

	nameField: function(el) {
		var values	= jQuery(el).val().split(/,\s*/);

		jQuery.msgbox('', {
			type: 'prompt',
			inputs  : [
      			{
					type:		'text',
					label:		'Module Name:',
					value:		values[0] ? values[0] : '',
					required:	true
				},
				{
					type:		'text',
					label:		'Module Display Name:',
					value:		values[1] ? values[1] : '',
					required:	false
				},
				{
					type:		'text',
					label:		'Include Media Into Module:',
					value:		values[2] ? values[2] : '',
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

jQuery(document).ready(function() {
	ExtStore.ExtGenerator.JModule.init();
});
