window.EStrap = (function (window, document, $, undefined) {
	'use strict';

	var app = {
		init: function () {
			console.log('working');
		}

	};
	$(document).ready(app.init);

	return app;
})(window, document, jQuery);
