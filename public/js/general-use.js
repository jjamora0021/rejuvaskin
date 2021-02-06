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
		var link_selector = loc.split("/")[1];
		$('#'+link_selector).addClass('active');
	},

    /**
     * [getMonthName description]
     * @param  {[type]} monthNumber [description]
     * @return {[type]}             [description]
     */
    getMonthName: function(monthNumber) {
        var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        return months[monthNumber - 1];
    },

	/**
	 * [renderPatientHistoryFields description]
	 * @return {[type]} [description]
	 */
	renderPatientHistoryFields: function(id, visit_count, meds)
	{
		visit_count++;
        var meds_dropdown = '';
        $.each(meds, function(index, el) {
            meds_dropdown += '<option value="'+el.id+'">'+el.medicine+'</option>';
        });
		var card = '<div class="card" id="card-'+visit_count+'">\
                        <div class="card-header d-flex p-3 bg-primary" id="heading'+visit_count+'" data-toggle="collapse" data-target="#collapse'+visit_count+'" aria-expanded="true" aria-controls="collapse'+visit_count+'">\
                            <div class="col-md-11 p-0">\
                            	<h4 class="mb-0 text-white" id="visit_count_header">\
	                                Visit '+ visit_count +'\
	                            </h4>\
                            </div>\
                            <div class="col-md-1 p-0 text-right">\
                            	<button class="btn btn-sm btn-danger" id="remove-card-btn" type="button" onclick="generalFunctions.removeAccordionCard('+visit_count+');">X</button>\
                        	</div>\
                        </div>\
                        <div id="collapse'+visit_count+'" class="collapse show" aria-labelledby="heading'+visit_count+'" data-parent="#accordion">\
                            <div class="card-body">\
                            	<div class="row">\
                                    <div class="col-md-9">\
                                        <div class="form-group">\
                                            <label class="form-control-label" for="last_procedure">Procedure</label><small><i><span class="text-danger">*</span></i></small>\
                                            <input type="text" name="last_procedure" class="form-control" placeholder="Facial" required>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-3">\
                                        <div class="form-group">\
                                            <label class="form-control-label" for="email">Date of Visit</label><small><i><span class="text-danger">*</span></i></small>\
                                            <div class="input-group">\
                                                <div class="input-group-prepend">\
                                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>\
                                                </div>\
                                                <input class="form-control datepicker" id="last_visit'+visit_count+'" placeholder="Select date" type="text" name="last_visit" required>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                                <div class="row">\
                                    <div class="col-md-12">\
                                        <div class="form-group">\
                                            <label class="form-control-label" for="remarks">Doctor Remarks</label><small><i><span class="text-danger">*</span></i></small>\
                                            <textarea class="form-control" name="remarks" rows="3" placeholder="Remarks here..."></textarea>\
                                        </div>\
                                    </div>\
                                </div>\
                                <div class="row justify-content-center">\
                                    <div class="col-md-6">\
                                        <div class="form-group">\
                                            <div class="input-group input-group-merge input-group-alternative">\
                                                <div class="input-group-prepend">\
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>\
                                                </div>\
                                               <select class="form-control selectpicker" data-live-search="true" id="medicine-input" data-style="btn-white" title="Select Medicine">\
                                                    '+meds_dropdown+'\
                                                </select>\
                                                <div class="input-group-append" id="button-addon4">\
                                                    <button class="btn btn-primary" type="button" onclick="generalFunctions.selectMedicine();">Select</button>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                                <div class="row justify-content-center">\
                                    <div class="col-md-6">\
                                        <ul class="list-group" id="medicine-used-list">\
                                        </ul>\
                                    </div>\
                                </div>\
                                <div class="row">\
                                    <div class="col-md-6">\
                                        <div class="form-group">\
                                            <label class="form-control-label" for="before_image">Before</label><small><i><span class="text-danger">*</span></i></small>\
                                            <input id="before_image" name="before_image" type="file" class="file" data-browse-on-zone-click="true">\
                                        </div>\
                                    </div>\
                                    <div class="col-md-6">\
                                        <div class="form-group">\
                                            <label class="form-control-label" for="after_image">After</label><small><i><span class="text-danger">*</span></i></small>\
                                            <input id="after_image" name="after_image" type="file" class="file" data-browse-on-zone-click="true">\
                                        </div>\
                                    </div>\
                                </div>\
                                <div class="row justify-content-center">\
                                    <div class="col-md-3">\
                                        <div class="form-group">\
                                            <label class="form-control-label" for="bill">Total Bill</label><small><i><span class="text-danger">*</span></i></small>\
                                            <input type="text" name="bill" class="form-control" placeholder="1000" required>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-3">\
                                        <div class="form-group">\
                                            <label class="form-control-label" for="discount">Discount</label><small><i><span class="text-danger">*</span></i></small>\
                                            <input type="text" name="discount" class="form-control" placeholder="500" required>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                    </div>';

        $('#patient-history-container #accordion').append(card);
        $('#patient-history-container #add-card-btn').prop('disabled', true);
        $('.no-history').addClass('d-none');

        $("#before_image, #after_image").fileinput({
            showUpload  : false,
            theme       : "fas",
        });

        $('.datepicker').datepicker().on('changeDate', function(ev){
            var date = new Date($('#last_visit'+visit_count).val());
            var str = 'Visit '+ visit_count + ' : ' + (generalFunctions.getMonthName((date.getMonth() + 1)) + ' ' + date.getDate() + ', ' + date.getFullYear());
            $('#visit_count_header').empty().append(str);
        });

        $('#medicine-input').selectpicker('refresh');
	},

    /**
     * [selectMedicine description]
     * @return {[type]} [description]
     */
    selectMedicine: function()
    {
        var med_selected = $('#medicine-input').val();
        var med_text = $.trim($('#medicine-input option:selected').text());

        var med =   '<li class="list-group-item">\
                        <div class="row align-items-center">\
                            <div class="col">\
                                <h4 class="mb-0">'+med_text+'</h4>\
                                <span class="text-primary">x</span>\
                                <small>1</small>\
                            </div>\
                            <div class="col-auto">\
                                <button type="button" class="btn btn-sm btn-success"><i class="fas fa-plus"></i></button>\
                                <button type="button" class="btn btn-sm btn-danger"><i class="fas fa-minus"></i></button>\
                            </div>\
                        </div>\
                    </li>';
        $('#medicine-used-list').append(med);
        console.log(med_selected);
        console.log(med_text)
    },

	/**
	 * [removeAccordionCard description]
	 * @return {[type]} [description]
	 */
	removeAccordionCard: function(visit_count)
	{
		$('#patient-history-container #remove-card-btn').toggleClass('d-none');
		$('#card-'+visit_count).remove();
		$('#patient-history-container #add-card-btn').prop('disabled', false);
	},

    /**
     * [openDeleteModal description]
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
 */
    openDeleteModal: function(id)
    {
        var param = "generalFunctions.deletePatientInfo("+id+")";
        var repop = "generalFunctions.repopulatePatientListTable();";
        var buttons =   '<button type="button" class="btn btn-danger new-event--add" id="delete-btn" onclick="'+param+'">Delete</button>\
                        <button type="button" class="btn btn-link ml-auto" data-dismiss="modal" onclick="'+repop+'">Close</button>';
        $('#delete-patient-modal .modal-footer').empty().append(buttons);
        $('#delete-patient-modal').modal();
    },

    /**
     * [deletePatientInfo description]
     * @param  {[type]} deletePatientInfo [description]
     * @return {[type]}                   [description]
     */
    deletePatientInfo: function(patient_id)
    {
        $.ajax({
            url: window.location.origin + '/delete-patient-information',
            data: {
                id : patient_id
            },
            success: function(response) {
                if(response == 1) {
                    $('#delete-patient-modal .modal-body .alert-success').removeClass('d-none');
                }
                else {
                    $('#delete-patient-modal .modal-body .alert-danger').removeClass('d-none');
                }
            }
        });
    },  

    /**
     * [repopulatePatientListTable description]
     * @return {[type]} [description]
     */
    repopulatePatientListTable: function()
    {
        if ($.fn.DataTable.isDataTable('#patient-list-table') ) {
            $('#patient-list-table').DataTable().destroy();
        }

        $('#patient-list-table tbody').empty();
        var table   =   $('#patient-list-table').DataTable({
                            columnDefs: [
                                {
                                    "targets": [ 0 ],
                                    "visible": false,
                                    "searchable": false
                                }
                            ],
                            columns: [
                                { data: "id" },
                                { data: "first_name" },
                                { data: "middle_name" },
                                { data: "last_name" },
                                { data: "birth_date" },
                                { data: "gender" },
                                { data: "home_number" },
                                { data: "mobile_number" },
                                { data: "email" },
                                { data: "address" },
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
            url: window.location.origin + '/fetch-all-patient-info',
            success: function(response) {
                $.each(response, function(index, el) {
                    var action_btn = '<td class="text-center">\
                                    <a class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="View Patient Info" href="'+window.location.origin+'/view-patient-information/'+el.id+'">\
                                        <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>\
                                    </a>\
                                    <a class="btn btn-sm btn-icon btn-warning" data-toggle="tooltip" data-placement="top" title="Update Patient Info" href="'+window.location.origin+'/update-patient-information/'+el.id+'">\
                                        <span class="btn-inner--icon"><i class="fas fa-edit"></i></span>\
                                    </a>\
                                    <button class="btn btn-sm btn-icon btn-danger" onclick="generalFunctions.openDeleteModal('+el.id+');">\
                                        <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>\
                                    </button>\
                                </td>';
                    el['action'] = action_btn;
                });
                table.rows.add(response).draw();

                $('#delete-patient-modal .modal-body .alert-success, #delete-patient-modal .modal-body .alert-danger').addClass('d-none');
            }
        });
    },
}