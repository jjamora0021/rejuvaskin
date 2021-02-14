/**
 * [description]
 */
timekeepingFunctions = {
    /**
     * [functions description]
     *
     * @return  {[type]}  [return description]
     */
    onLoad: function()
    {
        $('#time-sheet-table').DataTable({
            language: {
	            paginate: {
	                previous: '<i class="ni ni-bold-left"></i>', // or '>'
	                next: '<i class="ni ni-bold-right"></i>' // or '<'
	            }
	        },
            ordering: false,
        });

        timekeepingFunctions.displayCurrentTime();
    },

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
                    $('.alert-success').removeClass('d-none').empty().append('<strong>Time In Successful!</strong>').fadeOut(10000);
                }
                else {
                    $('.alert-danger').removeClass('d-none');
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
    saveTimeOut: function(today,emp_id, $this, id)
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
                id: id,
                emp_id  : emp_id,
                time_out : time_out_formatted,
                date    : date,
                total_hours: total_hours
            },
            success: function (response) {
                if(response == 1) {
                    $this.replaceWith(moment(time_out, ["h:mm:ss A"]).format("hh:mm A"));
                    $('.alert-success').removeClass('d-none').empty().append('<strong>Time Out Successful!</strong>').fadeOut(10000);
                    $('#'+date+' .total_hours').empty().append(total_hours);
                    var update_btn =    '<a class="btn btn-sm btn-icon btn-warning" data-toggle="tooltip" data-placement="top" title="Update Time Sheet" href="#">\
                                            <span class="btn-inner--icon">Dispute</span>\
                                        </a>';
                    $('#'+today+' td:eq(5)').empty().append(update_btn);
                }
                else {
                    $('.alert-danger').removeClass('d-none');
                }
            }
        });
    },
}
