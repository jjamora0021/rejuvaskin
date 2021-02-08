/**
 * [inventoryFunctions description]
 * @type {Object}
 */
inventoryFunctions = {
	/**
	 * [openUpdateStocksModal description]
	 * @param  {[type]} meds_name [description]
	 * @param  {[type]} meds_id   [description]
	 * @return {[type]}           [description]
	 */
	openUpdateStocksModal: function(meds_name, meds_id)
	{
		$('#update-stocks-modal #meds_id').val(meds_id);
		$('#update-stocks-modal #meds_name').val(meds_name);

		var param = "inventoryFunctions.updateStocks("+meds_id+")";
        var repop = "inventoryFunctions.repopulateInventoryListTable();";

		var buttons =   '<button type="button" class="btn btn-success new-event--add" id="restock-btn" onclick="'+param+'">Restock</button>\
                        <button type="button" class="btn btn-link ml-auto" data-dismiss="modal" onclick="'+repop+'">Close</button>';
        $('#update-stocks-modal .modal-footer').empty().append(buttons);
        $('#update-stocks-modal').modal();
	},

	/**
	 * [updateStocks description]
	 * @param  {[type]} meds_id [description]
	 * @return {[type]}         [description]
	 */
	updateStocks: function(meds_id)
	{
		var qty = $('#update-stocks-modal #quantity').val();
		var date_delivered = $('#update-stocks-modal #delivery_date').val();
		$.ajax({
			url: window.location.origin + '/update-inventory-list/' + meds_id,
			type: 'GET',
			data: {
				id : meds_id,
				stocks : qty,
				delivery_date : date_delivered
			},
			success: function(response) {
				if(response == 1) {
                    $('#update-stocks-modal .modal-body .alert-success').removeClass('d-none');
                }
                else {
                    $('#update-stocks-modal .modal-body .alert-danger').removeClass('d-none');
                }
			}
		});
	},

	/**
	 * [repopulateInventoryListTable description]
	 * @return {[type]} [description]
	 */
	repopulateInventoryListTable: function()
	{
		if ($.fn.DataTable.isDataTable('#inventory-table') ) {
            $('#inventory-table').DataTable().destroy();
        }

        $('#inventory-table tbody').empty();
        var table   =   $('#inventory-table').DataTable({
                            columnDefs: [
                                {
                                    "targets": [ 0 ],
                                    "visible": false,
                                    "searchable": false
                                }
                            ],
                            columns: [
                                { data: "id" },
                                { data: "medicine" },
                                { data: "stocks" },
                                { data: "updated_at" },
                                { data: "action" }
                            ],
                            language: {
                                paginate: {
                                    previous: '<i class="ni ni-bold-left"></i>', // or '>'
                                    next: '<i class="ni ni-bold-right"></i>' // or '<' 
                                }
                            }  
                        });

        $.ajax({
            url: window.location.origin + '/fetch-all-medicine-info',
            success: function(response) {
                $.each(response, function(index, el) {
                	var update_btn = "inventoryFunctions.openUpdateStocksModal('"+el.medicine+"',"+el.id+");";
                    var action_btn = '<td class="text-center">\
                                    <a class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="View Stocks History" href="#">\
                                        <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>\
                                    </a>\
                                    <button class="btn btn-sm btn-icon btn-warning" onclick="'+update_btn+'">\
                                        <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>\
                                    </button>\
                                    <button class="btn btn-sm btn-icon btn-danger" onclick="inventoryFunctions.openDeleteModal('+el.id+');">\
                                        <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>\
                                    </button>\
                                </td>';
                    el['action'] = action_btn;
                });
                table.rows.add(response).draw();

                $('#update-stocks-modal .modal-body .alert-success, #delete-patient-modal .modal-body .alert-danger').addClass('d-none');
            }
        });
	},

	/**
	 * [openDeleteModal description]
	 * @param  {[type]} id [description]
	 * @return {[type]}    [description]
	 */
	openDeleteModal: function(id)
    {
        var param = "inventoryFunctions.deleteMedicine("+id+")";
        var repop = "inventoryFunctions.repopulateInventoryListTable();";
        var buttons =   '<button type="button" class="btn btn-danger new-event--add" id="delete-btn" onclick="'+param+'">Delete</button>\
                        <button type="button" class="btn btn-link ml-auto" data-dismiss="modal" onclick="'+repop+'">Close</button>';
        $('#delete-medicine-modal .modal-footer').empty().append(buttons);
        $('#delete-medicine-modal').modal();
    },

    /**
     * [deletePatientInfo description]
     * @param  {[type]} patient_id [description]
     * @return {[type]}            [description]
     */
    deleteMedicine: function(meds_id)
    {
        $.ajax({
            url: window.location.origin + '/delete-medicine',
            data: {
                id : meds_id
            },
            success: function(response) {
                if(response == 1) {
                    $('#delete-medicine-modal .modal-body .alert-success').removeClass('d-none');
                }
                else {
                    $('#delete-medicine-modal .modal-body .alert-danger').removeClass('d-none');
                }
            }
        });
    },  

    /**
     * [openAddModal description]
     * @return {[type]} [description]
     */
    openAddModal: function()
    {
        $('#add-medicine-modal').modal();
    },

    /**
     * [resetFields description]
     * @return {[type]} [description]
     */
    resetFields: function()
    {
    	$('#add-medicine-modal input').val('');
    	$('#add-medicine-modal #file').fileinput('reset');
    	$('#add-medicine-modal #file').fileinput({
            showUpload  : false,
            theme       : "fas",
        });
    },
}