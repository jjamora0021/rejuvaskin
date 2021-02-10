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
                                },
                                {
                                    "className": "dt-center",
                                    "targets": [ 2, 3, 4 ]
                                },
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
    	$('#add-medicine-modal #row-medicine-container input').val('');
    	$('#upload-medicine-modal .card #file').fileinput('reset');
    	$('#upload-medicine-modal .card #file').fileinput({
            theme       : "fas",
        });

        if($('#add-medicine-modal .modal-body .alert-success').hasClass('d-none') == false)
        {
            $('#add-medicine-modal .modal-body .alert-success').addClass('d-none');
        }

        if($('#add-medicine-modal .modal-body .alert-danger').hasClass('d-none') == false)
        {
            $('#add-medicine-modal .modal-body .alert-danger').addClass('d-none');
        }
    },

    /**
     * [addMedicineRow description]
     */
    addMedicineRow: function(ctr)
    {
    	$('#medicine-row-'+ctr+' #deduct-btn-1').attr('disabled',false);
    	ctr++;
    	$('#row-counter').val(ctr);
    	var row = '<div class="row" id="medicine-row-'+ctr+'">\
                        <div class="col-md-7">\
                            <div class="form-group">\
                                <label class="form-control-label">Medicine</label><small><i><span class="text-danger">*</span></i></small>\
                                <input type="text" id="meds_name_'+ctr+'" class="form-control meds_name" name="meds_name['+ctr+']" value="" placeholder="Medicine Name" required>\
                            </div>\
                        </div>\
                        <div class="col-md-3">\
                            <div class="form-group">\
                                <label class="form-control-label">Quantity</label><small><i><span class="text-danger">*</span></i></small>\
                                <input type="number" id="quantity_'+ctr+'" name="quantity['+ctr+']" class="form-control meds_qty" placeholder="0" min="0" required>\
                            </div>\
                        </div>\
                        <div class="col-md-2 py-4 mt-3 text-center">\
                            <div class="form-group">\
                                <button type="button" class="btn btn-sm btn-success new-event--add" id="add-btn-'+ctr+'" onclick="inventoryFunctions.addMedicineRow('+ctr+');"><i class="fas fa-plus"></i></button>\
                                <button type="button" class="btn btn-sm btn-danger new-event--remove" id="deduct-btn-'+ctr+'" onclick="inventoryFunctions.deductMedicineRow('+ctr+');"><i class="fas fa-minus"></i></button>\
                            </div>\
                        </div>\
                    </div>';

        $('#row-medicine-container').append(row);
    },

    /**
     * [deductMedicineRow description]
     * @param  {[type]} ctr [description]
     * @return {[type]}     [description]
     */
    deductMedicineRow: function(ctr)
    {
    	ctr--;
    	$('#row-counter').val(ctr);
    	if($('#row-counter').val() == 2) {
    		$('#medicine-row-1 #deduct-btn-1').attr('disabled',true);
    	}

    	$('#medicine-row-'+ctr).remove();
    },

    /**
     * [addMedicine description]
     * @return {[type]}     [description]
     */
    addMedicine: function()
    {
    	$('#add-medicine-modal #add-medicine-form').off('submit').on('submit', function() {
		    var frm = $(this);
		    $.ajax({
		        type: "POST",
		        url: window.location.origin + '/add-medicine',
		        data: frm.serialize(),//serialize correct form
		        success: function(response) {
		            if(response == 1) {
                        $('#add-medicine-modal .modal-body .alert-success').removeClass('d-none');
                        inventoryFunctions.repopulateInventoryListTable();
                        inventoryFunctions.removeAllRows();
                    }
                    else {
                        $('#add-medicine-modal .modal-body .alert-danger').removeClass('d-none');
                    }
		        }
		    });
		    return false;
		});
    },

    /**
     * [uploadMedicine description]
     * @return {[type]}     [description]
     */
    uploadMedicine: function()
    {
        $('#upload-medicine-modal #add-medicine-form').off('submit').on('submit', function() {
		    var frm = new FormData($('#upload-medicine-modal #add-medicine-form')[0]);
		    $.ajax({
		        type: "POST",
		        url: window.location.origin + '/upload-medicine-list',
                dataType: 'json',
                contentType: false, // Important
                processData: false, // Important
		        data: frm,//serialize correct form
		        success: function(response) {
		            if(response == 1) {
                        $('#upload-medicine-modal .modal-body .alert-success').removeClass('d-none');
                        inventoryFunctions.repopulateInventoryListTable();
                        $('#upload-medicine-modal .card #file').fileinput('reset');
                        $('#upload-medicine-modal .card #file').fileinput({
                            showUpload  : false,
                            theme       : "fas",
                            // uploadUrl: '#',
                            browseOnZoneClick: true,
                            allowedPreviewTypes: false,
                            maxFileSize: 15000,
                            // uploadAsync: false,
                            uploadAsync: true,
                        });
                    }
                    else {
                        $('#upload-medicine-modal .modal-body .alert-danger').removeClass('d-none');
                    }
		        }
		    });
		    return false;
		});
    },

    /**
     * [removeAllRows description]
     * @return {[type]}     [description]
     */
    removeAllRows: function()
    {
    	var row = '<div class="row" id="medicine-row-1">\
                        <div class="col-md-7">\
                            <div class="form-group">\
                                <label class="form-control-label">Medicine</label><small><i><span class="text-danger">*</span></i></small>\
                                <input type="text" id="meds_name_1" class="form-control meds_name" name="meds_name[1]" value="" placeholder="Medicine Name" required>\
                            </div>\
                        </div>\
                        <div class="col-md-3">\
                            <div class="form-group">\
                                <label class="form-control-label">Quantity</label><small><i><span class="text-danger">*</span></i></small>\
                                <input type="number" id="quantity_1" name="quantity[1]" class="form-control meds_qty" placeholder="0" min="0" required>\
                            </div>\
                        </div>\
                        <div class="col-md-2 py-4 mt-3 text-center">\
                            <div class="form-group">\
                                <button type="button" class="btn btn-sm btn-success new-event--add" id="add-btn-1" onclick="inventoryFunctions.addMedicineRow(1);"><i class="fas fa-plus"></i></button>\
                                <button type="button" class="btn btn-sm btn-danger new-event--remove" id="deduct-btn-1" onclick="inventoryFunctions.deductMedicineRow(1);" disabled><i class="fas fa-minus"></i></button>\
                            </div>\
                        </div>\
                    </div>';

        $('#row-medicine-container').empty().append(row);
    },

    /**
     * [openUploadModal description]
     * @return {[type]}     [description]
     */
    openUploadModal: function()
    {
        $('#upload-medicine-modal').modal();
    },
}
