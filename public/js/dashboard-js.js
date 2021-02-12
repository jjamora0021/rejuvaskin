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
        $(document).ready(function() {
            $('table').DataTable({
                order: [
                    [ 4, "asc" ]
                ],
                language: {
                    paginate: {
                        previous: '<i class="ni ni-bold-left"></i>', // or '>'
                        next: '<i class="ni ni-bold-right"></i>' // or '<'
                    }
                }
            });
        });
    },

    /**
     * [toggleClass description]
     *
     * @return  {[type]}  [return description]
     */
    toggleClass: function()
    {
        $('#all-btn').toggleClass('active');
        $('#current-month-btn').toggleClass('active');
    },

    /**
     * [changeTableToAll description]
     *
     * @return  {[type]}  [return description]
     */
    changeTableToAll: function()
    {
        dashboardFunctions.toggleClass();
        window.location.reload();
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
        dashboardFunctions.toggleClass();
        $('#classification').empty().append(months[parseInt(month)]);

        if ($.fn.DataTable.isDataTable('#clinic-schedule-table') ) {
            $('#clinic-schedule-table').DataTable().destroy();
        }

        $('#clinic-schedule-table tbody').empty();
        var table   =   $('#clinic-schedule-table').DataTable({
                            order: [
                                [ 4, "asc" ]
                            ],
                            columnDefs: [
                                {
                                    "targets": [ 0 ],
                                    "visible": false,
                                    "searchable": false
                                },
                                {
                                    "className": "dt-center",
                                    "targets": [ 1, 2, 3, 4, 5, 6, 7 ]
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
}
