/**
 * @copyright	Copyright (c) 2019 ExtStore (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU/GPL version 2
 */

var ExtStore = ExtStore || {};

ExtStore.ExtGenerator = {
	download: function(link) {
		window.location = link;
	},

	addDetails: function(el, callback) {
		if (!(jQuery.browser.msie  && parseInt(jQuery.browser.version) == 7)) {
			jQuery(el).css('padding-right', '25px');
		}

		//var detail	= jQuery('<a href="javascript:void(0);" class="fieldDetails" />').insertAfter(jQuery(el));
		var detail	= jQuery('<span class="fieldDetails" />').insertAfter(jQuery(el));

		if (jQuery.isFunction(callback)) {
			detail.click(function() {
				callback(el);
			});
		}
	},

	updateValues: function(el, args) {
		//jQuery(el).focus();
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
	}
};
