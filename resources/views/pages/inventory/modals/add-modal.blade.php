<!-- Update Stocks Modal -->
<div class="modal fade" id="add-medicine-modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-secondary modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black">Add Medicine</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="inventoryFunctions.resetFields();">
                    <span aria-hidden="true" class="text-primary font-weight-bold">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-success d-none" role="alert">
                    <strong>Medicine(s) successfully added.</strong>
                </div>
                <div class="alert alert-danger d-none" role="alert">
                    <strong>Medicine(s) failed to be added.</strong>
                </div>

                <div class="card shadow">
                    <div class="card-body">
                        <form action="{{ route('add-medicine') }}" method="add-medicine" id="add-medicine-form">
                            @csrf
                            <input type="hidden" id="row-counter" name="row-counter" value="1">
                            <div id="row-medicine-container">
                                <div class="row" id="medicine-row-1">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label class="form-control-label">Medicine</label><small><i><span class="text-danger">*</span></i></small>
                                            <input type="text" id="meds_name_1" class="form-control meds_name" name="meds_name[1]" value="" placeholder="Medicine Name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label">Quantity</label><small><i><span class="text-danger">*</span></i></small>
                                            <input type="number" id="quantity_1" class="form-control meds_qty" name="quantity[1]" placeholder="0" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2 py-4 mt-3 text-center">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-sm btn-success new-event--add" id="add-btn-1" onclick="inventoryFunctions.addMedicineRow(1);"><i class="fas fa-plus"></i></button>
                                            <button type="button" class="btn btn-sm btn-danger new-event--remove" id="deduct-btn-1" onclick="inventoryFunctions.deductMedicineRow(1);" disabled><i class="fas fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success new-event--add" id="add-btn" onclick="inventoryFunctions.addMedicine();">Add</button>
                <button type="button" class="btn btn-link ml-auto text-danger" data-dismiss="modal" onclick="inventoryFunctions.resetFields();">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
