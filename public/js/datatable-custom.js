/**
 * [dataTableFunctions description]
 * @type {Object}
 */
dataTableFunctions = {
	/**
	 * [onLoad description]
	 * @return {[type]} [description]
	 */
	onLoad: function()
	{
		$('table').DataTable({
	        language: {
	            paginate: {
	                previous: '<i class="ni ni-bold-left"></i>', // or '>'
	                next: '<i class="ni ni-bold-right"></i>' // or '<' 
	            }
	        }
	    });
	}
}