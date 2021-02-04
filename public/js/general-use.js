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
	 * [renderPatientHistoryFields description]
	 * @return {[type]} [description]
	 */
	renderPatientHistoryFields: function(id, visit_count)
	{
		visit_count++;
		var card = '<div class="card" id="card-'+visit_count+'">\
                        <div class="card-header d-flex p-3" id="heading'+visit_count+'" data-toggle="collapse" data-target="#collapse'+visit_count+'" aria-expanded="true" aria-controls="collapse'+visit_count+'">\
                            <div class="col-md-11 p-0">\
                            	<h4 class="mb-0">\
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
                                                <input class="form-control datepicker" placeholder="Select date" type="text" name="last_visit" required>\
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
                                <div class="row">\
                                    <div class="col-md-6">\
                                        <div class="form-group">\
                                            <label class="form-control-label" for="before_image">Before</label><small><i><span class="text-danger">*</span></i></small>\
                                            <input id="before_image" name="before_image" type="file" class="file" data-browse-on-zone-click="true" request>\
                                        </div>\
                                    </div>\
                                    <div class="col-md-6">\
                                        <div class="form-group">\
                                            <label class="form-control-label" for="after_image">After</label><small><i><span class="text-danger">*</span></i></small>\
                                            <input id="after_image" name="after_image" type="file" class="file" data-browse-on-zone-click="true" request>\
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

        $('.datepicker').datepicker();
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
	}
}