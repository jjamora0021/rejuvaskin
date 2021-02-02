/**
 * [generalFunctions description]
 * @type {Object}
 */
generalFunctions = {
	/**
	 * [activateLink description]
	 * @param  {[type]} link [description]
	 * @return {[type]}      [description]
	 */
	onLoad: function()
	{
		var loc = window.location.pathname;
		$('#'+loc.split("/")[1]+' a').addClass('active');
	},
}