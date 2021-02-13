/**
 * [description]
 */
calendarFunctions = {
    /**
     * [onLoad description]
     *
     * @return  {[type]}  [return description]
     */
    onLoad: function()
    {
        calendarFunctions.initiateCalendar();
    },

    /**
     * [initiateCalendar description]
     *
     * @return  {[type]}  [return description]
     */
    initiateCalendar: function()
    {
        'use strict';
        var Fullcalendar = (function() {
            // Variables
            var $calendar = $('[data-toggle="calendar"]');
            // Init
            function init($this) {
                var data = JSON.parse($('#schedules').val());

                var events = [];
                $.each(data, function(index, value) {
                    var bg_class = '';
                    switch(value.status) {
                        case 'done':
                            bg_class = 'bg-success';
                            break;
                        case 'cancelled':
                            bg_class = 'bg-danger';
                            break;
                        default:
                            bg_class = 'bg-primary';
                    }

                    var obj = {
                        id: value.schedule_id,
                        title: value.procedure + ' - ' + value.first_name + ' ' + value.last_name,
                        start: value.date + 'T' + value.time,
                        allDay: false,
                        className: bg_class,
                        description: value.description
                    }
                    events.push(obj);
                });

                var options = {
                    header: {
                        right: '',
                        center: '',
                        left: ''
                    },
                    buttonIcons: {
                        prev: 'calendar--prev',
                        next: 'calendar--next'
                    },
                    theme: false,
                    selectable: true,
                    selectHelper: true,
                    editable: true,
                    events: events,
                    eventLimit: false,

                    dayClick: function(date) {
                        if($(this).hasClass('fc-sun') == false && $(this).hasClass('fc-sat') == false) {
                            var isoDate = moment(date).toISOString();
                            $('#new-event').modal('show');
                            $('.new-event--title').val('');
                            $('.new-event--start').val(isoDate);
                            $('.new-event--end').val(isoDate);

                            $.each(events, function(index, value) {
                                var d = value.start;
                                var date = d.split("T")[0];
                                var time = d.split("T")[1];
                                if(isoDate == date) {
                                    var time_selection = $('#new-event #create-schedule-modal-form #time option');
                                    $.each(time_selection, function(e, v) {
                                        if(v.value == time) {
                                            v.setAttribute('disabled', true);
                                            $('#new-event #create-schedule-modal-form #time').selectpicker('refresh');
                                        }
                                    });
                                }
                            });
                        }
                    },

                    viewRender: function(view) {
                        var calendarDate = $this.fullCalendar('getDate');
                        var calendarMonth = calendarDate.month();

                        //Set data attribute for header. This is used to switch header images using css
                        // $this.find('.fc-toolbar').attr('data-calendar-month', calendarMonth);

                        //Set title in page header
                        $('.fullcalendar-title').html(view.title);
                    },

                    // Edit calendar event action

                    eventClick: function(event, element) {
                        $('#edit-event input[value=' + event.className + ']').prop('checked', true);
                        $('#edit-event').modal('show');
                        $('.edit-event--id').val(event.id);
                        $('.edit-event--title').val(event.title);
                        $('.edit-event--description').val(event.description);

                        $.each(data, function(index, value) {
                            if(value.schedule_id == event.id) {
                                $('#edit-event #event').val(event.title);
                                $('#edit-event #patient').val(value.patient_id).selectpicker('refresh');
                                $('#edit-event #time').val(value.time).selectpicker('refresh');
                                $('#edit-event #date').val(value.date);
                                $('#edit-event #procedure').val(value.procedure);
                                $('#edit-event #description').val(value.description);
                                switch(value.status) {
                                    case 'done':
                                        $('#edit-event #bg-success').trigger('click');
                                        break;
                                    case 'cancelled':
                                        $('#edit-event #bg-danger').trigger('click');
                                        break;
                                    default:
                                        $('#edit-event #bg-default').trigger('click');
                                }
                            }
                        });
                    },

                };

                // Initalize the calendar plugin
                $this.fullCalendar(options);

                //Add new Event
                $('body').on('click', '.new-event--add', function() {
                    var eventTitle = $('.new-event--title').val();

                    // Generate ID
                    var GenRandom = {
                        Stored: [],
                        Job: function() {
                            var newId = Date.now().toString().substr(6); // or use any method that you want to achieve this string

                            if (!this.Check(newId)) {
                                this.Stored.push(newId);
                                return newId;
                            }
                            return this.Job();
                        },
                        Check: function(id) {
                            for (var i = 0; i < this.Stored.length; i++) {
                                if (this.Stored[i] == id) return true;
                            }
                            return false;
                        }
                    };

                    if (eventTitle != '') {
                        $this.fullCalendar('renderEvent', {
                            id: GenRandom.Job(),
                            title: eventTitle,
                            start: $('.new-event--start').val(),
                            end: $('.new-event--end').val(),
                            allDay: true,
                            className: $('.event-tag input:checked').val()
                        }, true);

                        $('.new-event--form')[0].reset();
                        $('.new-event--title').closest('.form-group').removeClass('has-danger');
                        $('#new-event').modal('hide');
                    } else {
                        $('.new-event--title').closest('.form-group').addClass('has-danger');
                        $('.new-event--title').focus();
                    }
                });

                //Update/Delete an Event
                $('body').on('click', '[data-calendar]', function() {
                    var calendarAction = $(this).data('calendar');
                    var currentId = $('.edit-event--id').val();
                    var currentTitle = $('.edit-event--title').val();
                    var currentDesc = $('.edit-event--description').val();
                    var currentClass = $('#edit-event .event-tag input:checked').val();
                    var currentEvent = $this.fullCalendar('clientEvents', currentId);

                    //Update
                    if (calendarAction === 'update') {
                        if (currentTitle != '') {
                            currentEvent[0].title = currentTitle;
                            currentEvent[0].description = currentDesc;
                            currentEvent[0].className = [currentClass];

                            $this.fullCalendar('updateEvent', currentEvent[0]);
                            $('#edit-event').modal('hide');
                        } else {
                            $('.edit-event--title').closest('.form-group').addClass('has-error');
                            $('.edit-event--title').focus();
                        }
                    }

                    //Delete
                    if (calendarAction === 'delete') {
                        $('#edit-event').modal('hide');

                        // Show confirm dialog
                        setTimeout(function() {
                            swal({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                type: 'warning',
                                showCancelButton: true,
                                buttonsStyling: false,
                                confirmButtonClass: 'btn btn-danger',
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonClass: 'btn btn-secondary'
                            }).then((result) => {
                                if (result.value) {
                                    // Delete event
                                    $this.fullCalendar('removeEvents', currentId);

                                    // Show confirmation
                                    swal({
                                        title: 'Deleted!',
                                        text: 'The event has been deleted.',
                                        type: 'success',
                                        buttonsStyling: false,
                                        confirmButtonClass: 'btn btn-primary'
                                    });
                                }
                            })
                        }, 200);
                    }
                });

                //Calendar views switch
                $('body').on('click', '[data-calendar-view]', function(e) {
                    e.preventDefault();

                    $('[data-calendar-view]').removeClass('active');
                    $(this).addClass('active');

                    var calendarView = $(this).attr('data-calendar-view');
                    $this.fullCalendar('changeView', calendarView);
                });

                //Calendar Next
                $('body').on('click', '.fullcalendar-btn-next', function(e) {
                    e.preventDefault();
                    $this.fullCalendar('next');
                });

                //Calendar Prev
                $('body').on('click', '.fullcalendar-btn-prev', function(e) {
                    e.preventDefault();
                    $this.fullCalendar('prev');
                });
            }

            // Init
            if ($calendar.length) {
                init($calendar);
            }
        })();
    },

    /**
     * [addEvent description]
     *
     * @return  {[type]}  [return description]
     */
    addEvent: function()
    {
        $('#new-event #create-schedule-modal-form').off('submit').on('submit', function() {
		    var frm = $(this);
		    $.ajax({
		        type: "POST",
		        url: window.location.origin + '/create-schedule',
		        data: frm.serialize(),//serialize correct form
                success: function(response) {
                    if(response != false) {
                        $('#new-event .modal-body .alert-success').removeClass('d-none');
                        $('#schedules').val(response)
                        $('#calendar-container #calendar').fullCalendar('destroy');
                        calendarFunctions.initiateCalendar();
                    }
                    else {
                        $('#new-event .modal-body .alert-danger').removeClass('d-none');
                    }
                }
		    });
		    return false;
		});
    },

    /**
     * [resetFields description]
     *
     * @param   {[type]}  modal  [modal description]
     *
     * @return  {[type]}         [return description]
     */
    resetFields: function(modal)
    {
        if(modal != 'edit-event') {
            if($('#'+modal+' .modal-body .alert-success').hasClass('d-none') == false) {
                $('#'+modal+' .modal-body .alert-success').addClass('d-none');
            }
            if($('#'+modal+' .modal-body .alert-danger').hasClass('d-none') == false) {
                $('#'+modal+' .modal-body .alert-danger').addClass('d-none');
            }
        }
        else {
            $('#'+modal+' #event').val('');
            $('#'+modal+' #patient').val('').selectpicker('refresh');
            $('#'+modal+' #time').val('').selectpicker('refresh');
            $('#'+modal+' #procedure').val('');
            $('#'+modal+' #description').val('');

            if($('#'+modal+' .modal-body .alert-success').hasClass('d-none') == false) {
                $('#'+modal+' .modal-body .alert-success').addClass('d-none');
            }
            if($('#'+modal+' .modal-body .alert-danger').hasClass('d-none') == false) {
                $('#'+modal+' .modal-body .alert-danger').addClass('d-none');
            }
        }

        window.location.reload();
    },

    /**
     * [updateSchedule description]
     *
     * @return  {[type]}  [return description]
     */
    updateSchedule: function()
    {
        $('#edit-event #update-schedule-modal-form').off('submit').on('submit', function() {
		    var frm = $(this);
		    $.ajax({
		        type: "PUT",
		        url: window.location.origin + '/update-schedule',
		        data: frm.serialize(),//serialize correct form
                success: function(response) {
                    if(response != false) {
                        $('#edit-event .modal-body .alert-success').removeClass('d-none');
                        $('#schedules').val(response)
                        $('#calendar-container #calendar').fullCalendar('destroy');
                        calendarFunctions.initiateCalendar();
                    }
                    else {
                        $('#edit-event .modal-body .alert-danger').removeClass('d-none');
                    }
                }
		    });
		    return false;
		});
    }
}
