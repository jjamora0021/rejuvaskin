<!-- Dispute Modal -->
<div class="modal fade" id="dispute-time-keeping-modal" tabindex="-1" aria-labelledby="dispute-time-keeping-modal" aria-hidden="true" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-secondary" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">Request Time Keeping Correction</h5>
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
                <form action="{{ route('send-time-keeping-request') }}" method="POST" id="send-time-keeping-request-form">
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
                                        <input class="form-control datepicker" placeholder="Select date" type="text" name="select_date" id="select_date" data-date-end-date="0d" data-date-format='yyyy-mm-dd' required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label" for="first_name">Time Keeping Request Type</label><small><i><span class="text-danger">*</span></i></small>
                                    <select name="type_of_dispute" id="type_of_dispute" class="form-control selectpicker" title="Choose request type" data-style="btn-white" onchange="timekeepingFunctions.setDisputeDataField(this)">
                                        <option value="" disabled="" selected="">Choose Request Type</option>
                                        <option value="time_in">Time In Correction</option>
                                        <option value="time_out">Time Out Correction</option>
                                        <option value="total_hours">Total Hours Correction</option>
                                        <option value="others">Others</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="time_in">Time In</label><small><i><span class="text-danger">*</span></i></small>
                                        <input type="text" id="time_in" name="dispute" class="form-control" value="{{ old('time_in') }}" placeholder="09:00 AM" required disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="time_out">Time Out</label><small><i><span class="text-danger">*</span></i></small>
                                        <input type="text" id="time_out" name="dispute" class="form-control" value="{{ old('time_out') }}" placeholder="04:00 PM" required disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-control-label" for="total_hours">Total Hours</label><small><i><span class="text-danger">*</span></i></small>
                                        <input type="text" id="total_hours" name="dispute" class="form-control" value="{{ old('total_hours') }}" placeholder="6.54" required disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="others">Others</label><small><i><span class="text-danger">*</span></i></small>
                                        <textarea type="text" id="others" rows="3" name="dispute" class="form-control" value="{{ old('others') }}" placeholder="Describe dispute" required disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-success" onclick="timekeepingFunctions.sendRequest();">Request</button>
                <button type="button" class="btn btn-link ml-auto" data-dismiss="modal">Close</button>
            </div>
                </form>
        </div>
    </div>
</div>
