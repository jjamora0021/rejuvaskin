/**
 * [description]
 */
timekeepingFunctions = {
    /**
     * [displayCurrentTime description]
     *
     * @return  {[type]}  [return description]
     */
    displayCurrentTime: function()
    {
        var today = new Date();
        var h = today.getHours() > 12 ? today.getHours() - 12 : today.getHours();
        var am_pm = today.getHours() >= 12 ? "PM" : "AM";
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = timekeepingFunctions.checkTime(m);
        s = timekeepingFunctions.checkTime(s);
        $('#clock').text(h + ":" + m + ":" + s + " " +  am_pm);
        var t = setTimeout(timekeepingFunctions.displayCurrentTime, 500);
    },

    /**
     * [checkTime description]
     *
     * @param   {[type]}  i  [i description]
     *
     * @return  {[type]}     [return description]
     */
    checkTime: function(i)
    {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10

        return i;
    },

    /**
     * [saveTimeIn description]
     *
     * @param   {[type]}  today  [today description]
     *
     * @return  {[type]}         [return description]
     */
    saveTimeIn: function(today,emp_id, $this)
    {
        var time_in = $('#clock').text();
        var time_in_formatted = moment(time_in, ["h:mm:ss A"]).format("HH:mm:ss");
        var date = today;

        $.ajax({
            url: window.location.origin + '/save-time-in',
            data: {
                emp_id  : emp_id,
                time_in : time_in_formatted,
                date    : date
            },
            success: function (response) {
                if(response == 1) {
                    $this.replaceWith(moment(time_in, ["h:mm:ss A"]).format("hh:mm A"));
                    $('.alert-success').removeClass('d-none').empty().append('<strong>Time In Successful!</strong>');
                    setTimeout(function(){  $('.alert-success').addClass('d-none') }, 10000);
                    $('#'+today+' td:eq(3) button').prop('disabled', false);
                }
                else {
                    $('.alert-danger').removeClass('d-none');
                    setTimeout(function(){  $('.alert-danger').addClass('d-none') }, 10000);
                }
            }
        });
    },

    /**
     * [saveTimeOut description]
     *
     * @param   {[type]}  today  [today description]
     *
     * @return  {[type]}         [return description]
     */
    saveTimeOut: function(today,emp_id, $this)
    {
        var time_out = $('#clock').text();
        var time_out_formatted = moment(time_out, ["h:mm:ss A"]).format("HH:mm:ss");
        var time_in = $('#'+today+' td:eq(2)').text();
        var time_in_formatted = moment(time_in, ["h:mm:ss A"]).format("HH:mm:ss");
        var date = today;

        var total_hours = parseFloat(((new Date(today + " " +time_out_formatted) - new Date(today + " " +time_in_formatted)) / 60 / 60 / 1000).toFixed(2)) ;

        $.ajax({
            url: window.location.origin + '/save-time-out',
            data: {
                emp_id  : emp_id,
                time_out : time_out_formatted,
                date    : date,
                total_hours: total_hours
            },
            success: function (response) {
                if(response == 1) {
                    $this.replaceWith(moment(time_out, ["h:mm:ss A"]).format("hh:mm A"));
                    console.log($this);
                    // $($this).removeClass('text-primary').addClass('text-success');
                    $('.alert-success').removeClass('d-none').empty().append('<strong>Time Out Successful!</strong>');
                    setTimeout(function(){  $('.alert-success').addClass('d-none') }, 10000);
                    $('#'+date+' .total_hours').empty().append(total_hours);
                }
                else {
                    $('.alert-danger').removeClass('d-none');
                    setTimeout(function(){  $('.alert-danger').addClass('d-none') }, 10000);
                }
            }
        });
    },

    /**
     * [setDisputeDataField description]
     *
     * @param   {[type]}  $this  [$this description]
     *
     * @return  {[type]}         [return description]
     */
    setDisputeDataField: function($this)
    {
        var selected = $this.value;
        switch (selected) {
            case 'time_in':
                $('#time_in').prop('disabled', false);
                $('#time_out, #total_hours, #others').val('').prop('disabled', true);
                break;
            case 'time_out':
                $('#time_out').prop('disabled', false);
                $('#time_in, #total_hours, #others').val('').prop('disabled', true);
                break;
            case 'total_hours':
                $('#total_hours').prop('disabled', false);
                $('#time_in, #time_out, #others').val('').prop('disabled', true);
                break;
            default:
                $('#others').prop('disabled', false);
                $('#time_in, #time_out, #total_hours').val('').prop('disabled', true);
                break;
        }
        $('#select_date').prop('disabled', false);
    },

    /**
     * [sendRequest description]
     *
     * @return  {[type]}  [return description]
     */
    sendRequest: function()
    {
        $('#send-time-keeping-request-form').off('submit').on('submit', function() {
		    var frm = $(this);
		    $.ajax({
		        type: "POST",
		        url: window.location.origin + '/send-time-keeping-request',
		        data: frm.serialize(),//serialize correct form
                success: function(response) {
                    if(response != false) {
                        $('#dispute-time-keeping-modal .modal-body .alert-success').removeClass('d-none');
                        setTimeout(function(){  $('.alert-success').addClass('d-none') }, 10000);
                        $('#form-container input, #form-container #others').val('').prop('disabled', true);
                        $('#form-container #select_date').val('').datepicker('refresh');
                        $('#form-container #type_of_dispute').val('').selectpicker('refresh');
                    }
                    else {
                        $('#dispute-time-keeping-modal .modal-body .alert-danger').removeClass('d-none');
                        setTimeout(function(){  $('.alert-danger').addClass('d-none') }, 10000);
                    }
                    $('#select_date').prop('disabled', false);
                }
		    });
		    return false;
		});
    },

    /**
     * [openActionModal description]
     *
     * @param   {[type]}  action      [action description]
     * @param   {[type]}  dispute_id  [dispute_id description]
     *
     * @return  {[type]}              [return description]
     */
    openActionModal: function(action, dispute_id)
    {
        $('#action-modal').modal();
        $('#action-modal #dispute_id').val(dispute_id);
        $('#action-modal #action').val(action);
    },

    /**
     * [updateDispute description]
     *
     * @return  {[type]}  [return description]
     */
    updateDispute: function()
    {
        $('#action-modal #action-form').off('submit').on('submit', function() {
            var row_id =  $('#action-modal #dispute_id').val();
		    var frm = $(this);
		    $.ajax({
		        type: "POST",
		        url: window.location.origin + '/update-dispute',
		        data: frm.serialize(),//serialize correct form
                success: function(response) {
                    if(response != false) {
                        $('#action-modal .modal-body .alert-success').empty().append('<strong>Action Success.</strong>').removeClass('d-none');
                        setTimeout(function(){  $('.alert-success').addClass('d-none') }, 10000);

                        $('#action-modal #action-form .btn-success').prop('disabled', true);

                        timekeepingFunctions.repopulateTimeKeepingDisputesTable(JSON.parse(response));
                    }
                    else {
                        $('#action-modal .modal-body .alert-danger').empty().append('<strong>Action Failed.</strong>').removeClass('d-none');
                        setTimeout(function(){  $('.alert-danger').addClass('d-none') }, 10000);
                    }
                }
		    });
		    return false;
		});
    },

    /**
     * [repopulateTimeKeepingDisputesTable description]
     *
     * @param   {[type]}  data  [data description]
     *
     * @return  {[type]}        [return description]
     */
    repopulateTimeKeepingDisputesTable: function(data)
    {
        if ($.fn.DataTable.isDataTable('#time-keeping-dispute-table') ) {
            $('#time-keeping-dispute-table').DataTable().destroy();
        }

        $('#time-keeping-dispute-table tbody').empty();
        var table   =   $('#time-keeping-dispute-table').DataTable({
                            columnDefs: [
                                {
                                    "targets": [ 0 ],
                                    "visible": false,
                                    "searchable": false
                                },
                                {
                                    "className": "dt-center",
                                    "targets": [ 2, 3, 4, 5, 6 ]
                                },
                            ],
                            columns: [
                                { data: "dispute_id" },
                                { data: "full_name" },
                                { data: "date_in_dispute" },
                                { data: "type_of_dispute" },
                                { data: "dispute" },
                                { data: "dispute_status" },
                                { data: "approved_by" },
                                { data: "remarks" },
                                { data: "action" }
                            ],
                            language: {
                                paginate: {
                                    previous: '<i class="ni ni-bold-left"></i>', // or '>'
                                    next: '<i class="ni ni-bold-right"></i>' // or '<'
                                }
                            }
                        });

        $.each(data, function(index, el) {
            var action_btn = '<td class="text-center">\
                                <button class="btn btn-sm btn-icon btn-success" disabled>\
                                    <i class="fas fa-check"></i>\
                                </button>\
                                <button class="btn btn-sm btn-icon btn-danger" disabled>\
                                    <i class="fas fa-times"></i>\
                                </button>\
                            </td>';
            el['action'] = action_btn;
        });
        table.rows.add(data).draw();
        $('[data-toggle="tooltip"]').tooltip();
    },

    /**
     * [sendLeaveRequest description]
     *
     * @return  {[type]}  [return description]
     */
    sendLeaveRequest: function()
    {
        $('#leave-request-modal #send-leave-request-form').off('submit').on('submit', function() {
		    var frm = $(this);
		    $.ajax({
		        type: "POST",
		        url: window.location.origin + '/send-leave-request',
		        data: frm.serialize(),//serialize correct form
                success: function(response) {
                    if(response == 1) {
                        $('#leave-request-modal .modal-body .alert-success').empty().append('<strong>Action Success.</strong>').removeClass('d-none');
                        setTimeout(function(){  $('.alert-success').addClass('d-none') }, 10000);

                        $('#leave-request-modal #send-leave-request-form #select_date').val('').datepicker("refresh");
                        $('#leave-request-modal #send-leave-request-form #leave_type').val('').selectpicker('refresh');
                        $('#leave-request-modal #send-leave-request-form #description').val('');
                    }
                    else {
                        $('#leave-request-modal .modal-body .alert-danger').empty().append('<strong>Action Failed.</strong>').removeClass('d-none');
                        setTimeout(function(){  $('.alert-danger').addClass('d-none') }, 10000);
                    }
                }
		    });
		    return false;
		});
    }
}
