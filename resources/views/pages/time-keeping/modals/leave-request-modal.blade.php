<!-- Leave Request Modal -->
<div class="modal fade" id="leave-request-modal" tabindex="-1" aria-labelledby="leave-request-modal" aria-hidden="true" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-secondary" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">Leave Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-black">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-success d-none" role="alert">
                    <strong>Request Successfully sent.</strong>
                </div>
                <div class="alert alert-danger d-none" role="alert">
                    <strong>Request failed to be sent.</strong>
                </div>
                <form action="{{ route('send-leave-request') }}" method="POST" id="send-leave-request-form">
                    @csrf
                    <input type="hidden" value="{{ Auth::user()->id }}" name="emp_id" id="emp_id">
                    <div id="form-container">
                        <div class="form-group mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label" for="select_date">Select Date</label><small><i><span class="text-danger">*</span></i></small>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                        </div>
                                        <input class="form-control datepicker" placeholder="Select date" type="text" name="select_date" id="select_date" data-date-format='yyyy-mm-dd' required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label">Leave Type</label><small><i><span class="text-danger">*</span></i></small>
                                    <select name="leave_type" id="leave_type" class="form-control selectpicker" title="Choose request type" data-style="btn-white" required>
                                        <option value="" disabled="" selected="">Choose Leave Type</option>
                                        <option value="holiday_leave">Holiday Leave</option>
                                        <option value="vacation_leave" data-subtext="{{ Auth::user()->vacation_leave }} left" {{ (Auth::user()->vacation_leave == 0) ? 'disabled' : '' }}>Vacation Leave</option>
                                        <option value="sick_leave" data-subtext="{{ Auth::user()->sick_leave }} left" {{ (Auth::user()->sick_leave == 0) ? 'disabled' : '' }}>Sick Leave</option>
                                        <option value="service_incentive_leave" data-subtext="{{ Auth::user()->service_incentive_leave }} left" {{ (Auth::user()->service_incentive_leave == 0) ? 'disabled' : '' }}>Service Incentive Leave</option>
                                        <option value="updaid_leave">Unpaid Leave</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-control-label" for="description">Description</label><small><i><span class="text-danger">*</span></i></small>
                                    <textarea type="text" id="description" rows="3" name="description" class="form-control" value="{{ old('description') }}" placeholder="Describe Leave" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-success" onclick="timekeepingFunctions.sendLeaveRequest();">Request</button>
                <button type="button" class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
            </div>
                </form>
        </div>
    </div>
</div>
