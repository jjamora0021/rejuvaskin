var months = [];
    months[1] = 'January';
    months[2] = 'February';
    months[3] = 'March';
    months[4] = 'April';
    months[5] = 'May';
    months[6] = 'June';
    months[7] = 'July';
    months[8] = 'August';
    months[9] = 'September';
    months[10] = 'October';
    months[11] = 'November';
    months[12] = 'December';
/**
 * [description]
 */
dashboardFunctions = {
    /**
     * [onLoad description]
     *
     * @return  {[type]}  [return description]
     */
    onLoad: function()
    {
        $('#dashboard-link a').addClass('active');
        $('table').DataTable({
            ordering: false,
            language: {
                paginate: {
                    previous: '<i class="ni ni-bold-left"></i>', // or '>'
                    next: '<i class="ni ni-bold-right"></i>' // or '<'
                }
            }
        });
    },

    /**
     * [changeTableToAll description]
     *
     * @return  {[type]}  [return description]
     */
    changeTableToAll: function()
    {
        window.location.reload();
    },

    /**
     * [renderTable description]
     *
     * @return  {[type]}  [return description]
     */
    renderTable: function()
    {
        if ($.fn.DataTable.isDataTable('#clinic-schedule-table') ) {
            $('#clinic-schedule-table').DataTable().destroy();
        }

        $('#clinic-schedule-table tbody').empty();
        var table   =   $('#clinic-schedule-table').DataTable({
                            ordering: false,
                            columnDefs: [
                                {
                                    "targets": [ 0 ],
                                    "visible": false,
                                    "searchable": false
                                },
                                {
                                    "className": "dt-center",
                                    "targets": [ 4, 5, 6, 7 ]
                                },
                            ],
                            columns: [
                                { data: "patient_id" },
                                { data: "patient" },
                                { data: "procedure" },
                                { data: "description" },
                                { data: "date" },
                                { data: "time" },
                                { data: "status" },
                                { data: "action" }
                            ],
                            language: {
                                paginate: {
                                    previous: '<i class="ni ni-bold-left"></i>', // or '>'
                                    next: '<i class="ni ni-bold-right"></i>' // or '<'
                                }
                            },
                            createdRow: function (row, data, dataIndex) {
                                switch (data.status) {
                                    case 'DONE':
                                        $(row).addClass('text-success font-weight-bold');
                                        break;
                                    case 'CANCELLED':
                                        $(row).addClass('text-danger font-weight-bold');
                                        break;
                                    default:
                                        break;
                                }
                            },
                        });

        return table;
    },

    /**
     * [changeTableToCurrentMonth description]
     *
     * @param   {[type]}  month  [month description]
     *
     * @return  {[type]}         [return description]
     */
    changeTableToCurrentMonth: function(month)
    {
        $('#current-month-btn').addClass('active');
        $('#all-btn').removeClass('active');
        $('#today-btn').removeClass('active');

        $('#classification').empty().append(months[parseInt(month)]);

        var table = dashboardFunctions.renderTable();

        $.ajax({
            url: window.location.origin + '/fetch-all-schedule-per-month',
            data: { month : month },
            success: function (response) {
                $.each(response, function(index, el) {
                	var update_btn = "dashboardFunctions.openUpdateStocksModal('"+el.schedule_id+"');";
                    var action_btn = '<td class="text-center">\
                                            <a class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="View Patient Info" href="'+ window.location.origin +'/view-patient-information/'+ el.patient_id +'">\
                                                <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>\
                                            </a>\
                                            <button class="btn btn-sm btn-icon btn-danger" onclick="dashboardFunctions.openDeleteModal('+ el.schedule_id +');" data-toggle="tooltip" data-placement="top" title="Delete Schedule">\
                                                <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>\
                                            </button>\
                                        </td>';
                    el['action'] = action_btn;
                });
                table.rows.add(response).draw();
                $('[data-toggle="tooltip"]').tooltip()
            }
        });
    },

    /**
     * [changeTableToToday description]
     *
     * @param   {[type]}  today  [today description]
     *
     * @return  {[type]}         [return description]
     */
    changeTableToToday: function(today)
    {
        $('#all-btn').removeClass('active');
        $('#current-month-btn').removeClass('active');
        $('#today-btn').addClass('active');

        $('#classification').empty().append('Today');

        var table = dashboardFunctions.renderTable();

        $.ajax({
            url: window.location.origin + '/fetch-all-schedule-today',
            data: { date : today },
            success: function (response) {
                $.each(response, function(index, el) {
                	var update_btn = "dashboardFunctions.openUpdateStocksModal('"+el.schedule_id+"');";
                    var action_btn = '<td class="text-center">\
                                            <a class="btn btn-sm btn-icon btn-primary" data-toggle="tooltip" data-placement="top" title="View Patient Info" href="'+ window.location.origin +'/view-patient-information/'+ el.patient_id +'">\
                                                <span class="btn-inner--icon"><i class="fas fa-eye"></i></span>\
                                            </a>\
                                            <button class="btn btn-sm btn-icon btn-danger" onclick="dashboardFunctions.openDeleteModal('+ el.schedule_id +');" data-toggle="tooltip" data-placement="top" title="Delete Schedule">\
                                                <span class="btn-inner--icon"><i class="fas fa-trash"></i></span>\
                                            </button>\
                                        </td>';
                    el['action'] = action_btn;
                });
                table.rows.add(response).draw();
                $('[data-toggle="tooltip"]').tooltip()
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
        $('#delete-schedule-modal').modal();
        var classfication = $('#classification').text();

        var param = "dashboardFunctions.deleteSchedule("+id+",'"+classfication+"')";
        var buttons =   '<button type="button" class="btn btn-danger new-event--add" id="delete-btn" onclick="'+param+'">Delete</button>\
                        <button type="button" class="btn btn-link ml-auto" data-dismiss="modal">Close</button>';
        $('#delete-schedule-modal .modal-footer').empty().append(buttons);
        $('#delete-schedule-modal').modal();
    },

    /**
     * [deleteSchedule description]
     *
     * @param   {[type]}  id  [id description]
     *
     * @return  {[type]}      [return description]
     */
    deleteSchedule: function(id, classification)
    {
        $.ajax({
            url: window.location.origin + '/delete-schedule',
            data: { id : id },
            success: function (response) {
                if(response == 1)
                {
                    $('#delete-schedule-modal .alert-success').removeClass('d-none');

                    buttons =   '<button type="button" class="btn btn-danger new-event--add" id="delete-btn" disabled>Delete</button>\
                                        <button type="button" class="btn btn-link ml-auto" data-dismiss="modal" onclick="window.location.reload()">Close</button>';

                    $('#delete-schedule-modal .modal-footer').empty().append(buttons);
                }
                else
                {
                    $('#delete-schedule-modal .alert-danger').removeClass('d-none');
                }
            }
        });
    }
}
