@extends('layouts.app')

@section('page-css')

@endsection

@section('content')
<div class="container-fluid py-4">
    <input type="hidden" value="{{ $schedules }}" id="schedules">
    <div class="header-body">
        <div class="row align-items-center py-4">
            <div class="col-lg-6">
                <h6 class="fullcalendar-title h2 text-primary d-inline-block mb-0">February 2021</h6>
            </div>
            <div class="col-lg-6 mt-3 mt-lg-0 text-lg-right">
                <a href="javascript:;" class="fullcalendar-btn-prev btn btn-sm btn-primary">
                    <i class="fas fa-angle-left"></i>
                </a>
                <a href="javascript:;" class="fullcalendar-btn-next btn btn-sm btn-primary">
                    <i class="fas fa-angle-right"></i>
                </a>

                <a href="javascript:;" class="btn btn-sm btn-primary" data-calendar-view="month">Month</a>
                <a href="javascript:;" class="btn btn-sm btn-primary" data-calendar-view="basicWeek">Week</a>
                <a href="javascript:;" class="btn btn-sm btn-primary" data-calendar-view="basicDay">Day</a>
            </div>
        </div>
    </div>
    <div class="container-fluid mt--2">
        <div class="row">
            <div class="col">
                <!-- Fullcalendar -->
                <div class="card card-calendar">
                    <!-- Card header -->
                    <div class="card-header">
                        <!-- Title -->
                        <h5 class="h3 mb-0">Calendar</h5>
                    </div>
                    <!-- Card body -->
                    <div class="card-body p-0" id="calendar-container">
                        <div class="calendar" data-toggle="calendar" id="calendar"></div>
                    </div>
                </div>
                <!-- Modal - Add new event -->
                <!--* Modal header *-->
                <!--* Modal body *-->
                <!--* Modal footer *-->
                <!--* Modal init *-->
                <div class="modal fade" id="new-event" tabindex="-1" role="dialog" aria-labelledby="new-event-label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-secondary" role="document">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="alert alert-success d-none" role="alert">
                                    <strong>Schedule successfully added.</strong>
                                </div>
                                <div class="alert alert-danger d-none" role="alert">
                                    <strong>Schedule failed to be added.</strong>
                                </div>

                                <form class="new-event--form" method="POST" action="{{ route('create-schedule') }}" id="create-schedule-modal-form">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-control-label">Schedule Title</label><small><i><span class="text-danger">*</span></i></small>
                                        <input type="text" name="event" id="event" class="form-control form-control-alternative new-event--title" placeholder="Schedule Title">
                                    </div>
                                    <div class="form-group row ">
                                        <div class="col-md-6">
                                            <label class="form-control-label" for="patient">Patient</label><small><i><span class="text-danger">*</span></i></small>
                                            <select class="form-control selectpicker" data-live-search-placeholder="Search here.." data-actions-box="true" data-live-search="true" name="patient" id="patient" data-style="btn-white" title="Select Patient" required>
                                                @if(!empty($patients))
                                                    <option value="" disabled selected>Choose Patient</option>
                                                    @foreach($patients as $key => $value)
                                                        <option value="{{ $value->id }}">{{ $value->first_name . ' ' . $value->last_name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled selected>No Patients Records</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-control-label" for="time">Time of Procedure</label><small><i><span class="text-danger">*</span></i></small>
                                            <select class="form-control selectpicker" data-actions-box="true" name="time" id="time" data-style="btn-white" title="Select Time" required>
                                                <option value="" disabled selected>Choose Time</option>
                                                <option value="08:00:00">8:00 AM</option>
                                                <option value="08:30:00">8:30 AM</option>
                                                <option value="09:00:00">9:00 AM</option>
                                                <option value="09:30:00">9:30 AM</option>
                                                <option value="10:00:00">10:00 AM</option>
                                                <option value="10:30:00">10:30 AM</option>
                                                <option value="11:00:00">11:00 AM</option>
                                                <option value="11:30:00">11:30 AM</option>
                                                <option value="12:00:00">12:00 PM</option>
                                                <option value="12:30:00">12:30 PM</option>
                                                <option value="13:00:00">01:00 PM</option>
                                                <option value="13:30:00">01:30 PM</option>
                                                <option value="14:00:00">02:00 PM</option>
                                                <option value="14:30:00">02:30 PM</option>
                                                <option value="15:00:00">03:00 PM</option>
                                                <option value="15:30:00">03:30 PM</option>
                                                <option value="16:00:00">04:00 PM</option>
                                                <option value="16:30:00">04:30 PM</option>
                                                <option value="17:00:00">05:00 PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Procedure</label><small><i><span class="text-danger">*</span></i></small>
                                        <input type="text" name="procedure" id="procedure" class="form-control form-control-alternative new-event--title" placeholder="Procedure">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Description</label><small><i><span class="text-danger">*</span></i></small>
                                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Short Description"></textarea>
                                    </div>
                                    <input type="hidden" name="date_start" class="new-event--start" />
                                    <input type="hidden" name="date_end" class="new-event--end" />
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary new-event--add" onclick="calendarFunctions.addEvent();">Add event</button>
                                <button type="button" class="btn btn-link ml-auto" data-dismiss="modal" onclick="calendarFunctions.resetFields('new-event');">Close</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <!-- Modal - Edit event -->
                <!--* Modal body *-->
                <!--* Modal footer *-->
                <!--* Modal init *-->
                <div class="modal fade" id="edit-event" tabindex="-1" role="dialog" aria-labelledby="edit-event-label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-secondary" role="document">
                        <div class="modal-content">
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="alert alert-success d-none" role="alert">
                                    <strong>Schedule successfully updated.</strong>
                                </div>
                                <div class="alert alert-danger d-none" role="alert">
                                    <strong>Schedule failed to be updated.</strong>
                                </div>

                                <form class="edit-event--form" method="PUT" action="{{ route('update-schedule') }}" id="update-schedule-modal-form">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-control-label">Schedule Title</label><small><i><span class="text-danger">*</span></i></small>
                                        <input type="text" name="event" id="event" class="form-control form-control-alternative new-event--title" placeholder="Schedule Title">
                                    </div>
                                    <div class="form-group row ">
                                        <div class="col-md-6">
                                            <label class="form-control-label" for="patient">Patient</label><small><i><span class="text-danger">*</span></i></small>
                                            <select class="form-control selectpicker" data-live-search-placeholder="Search here.." data-actions-box="true" data-live-search="true" name="patient" id="patient" data-style="btn-white" title="Select Patient" required>
                                                @if(!empty($patients))
                                                    <option value="" disabled selected>Choose Patient</option>
                                                    @foreach($patients as $key => $value)
                                                        <option value="{{ $value->id }}">{{ $value->first_name . ' ' . $value->last_name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled selected>No Patients Records</option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-control-label" for="time">Time of Procedure</label><small><i><span class="text-danger">*</span></i></small>
                                            <select class="form-control selectpicker" data-actions-box="true" name="time" id="time" data-style="btn-white" title="Select Time" required>
                                                <option value="" disabled selected>Choose Time</option>
                                                <option value="08:00:00">8:00 AM</option>
                                                <option value="08:30:00">8:30 AM</option>
                                                <option value="09:00:00">9:00 AM</option>
                                                <option value="09:30:00">9:30 AM</option>
                                                <option value="10:00:00">10:00 AM</option>
                                                <option value="10:30:00">10:30 AM</option>
                                                <option value="11:00:00">11:00 AM</option>
                                                <option value="11:30:00">11:30 AM</option>
                                                <option value="12:00:00">12:00 PM</option>
                                                <option value="12:30:00">12:30 PM</option>
                                                <option value="13:00:00">01:00 PM</option>
                                                <option value="13:30:00">01:30 PM</option>
                                                <option value="14:00:00">02:00 PM</option>
                                                <option value="14:30:00">02:30 PM</option>
                                                <option value="15:00:00">03:00 PM</option>
                                                <option value="15:30:00">03:30 PM</option>
                                                <option value="16:00:00">04:00 PM</option>
                                                <option value="16:30:00">04:30 PM</option>
                                                <option value="17:00:00">05:00 PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Procedure</label><small><i><span class="text-danger">*</span></i></small>
                                        <input type="text" name="procedure" id="procedure" class="form-control form-control-alternative new-event--title" placeholder="Procedure">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Description</label><small><i><span class="text-danger">*</span></i></small>
                                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Short Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label d-block mb-3">Status color</label>
                                        <div class="btn-group btn-group-toggle btn-group-colors event-tag mb-0" data-toggle="buttons">
                                            <label class="btn bg-primary"><input type="radio" id="bg-default" name="event-status" value="bg-default" autocomplete="off"></label>
                                            <label class="btn bg-success"><input type="radio" id="bg-success" name="event-status" value="bg-success" autocomplete="off"></label>
                                            <label class="btn bg-danger"><input type="radio" id="bg-danger" name="event-status" value="bg-danger" autocomplete="off"></label>
                                        </div>
                                    </div>
                                    <input type="hidden" name="id" class="edit-event--id">
                                    <input type="hidden" name="date" id="date">
                            </div>
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary edit-event--add" onclick="calendarFunctions.updateSchedule();">Update</button>
                                <button type="button" class="btn btn-link ml-auto" data-dismiss="modal" onclick="calendarFunctions.resetFields('edit-event')">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page-js')
    <script src="{{ asset('js/calendar.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            calendarFunctions.onLoad();
        });
    </script>
@endsection
