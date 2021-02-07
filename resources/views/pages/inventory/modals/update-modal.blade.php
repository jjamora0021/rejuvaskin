<!-- Update Stocks Modal -->
<div class="modal fade" id="update-stocks-modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-secondary modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black">Update Stocks - Restock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-black">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-success d-none" role="alert">
                    <strong>Medicine Inventory successfully updated.</strong>
                </div>
                <div class="alert alert-danger d-none" role="alert">
                    <strong>Medicine Inventory failed to be updated.</strong>
                </div>
                <div class="row">
                    <input type="hidden" id="meds_id" value="">
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="form-control-label">Medicine</label>
                            <input type="text" id="meds_name" class="form-control" value="" placeholder="Medicine Name" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-control-label">Quantity</label><small><i><span class="text-danger">*</span></i></small>
                            <input type="number" id="quantity" class="form-control" placeholder="0" min="0" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="form-control-label" for="birth_date">Date Delivered</label><small><i><span class="text-danger">*</span></i></small>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                                </div>
                                <input class="form-control datepicker" placeholder="Select date" type="text" id="delivery_date" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>