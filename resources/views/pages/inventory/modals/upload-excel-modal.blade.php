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
                        <div class="col-md-12">
						    <div class="form-group">
						        <label class="form-control-label" for="before_image">Upload an Excel File</label>
						        <input id="file" type="file" class="file" data-browse-on-zone-click="true" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
						    </div>
						</div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success new-event--add" id="add-btn" onclick="inventoryFunctions.addMedicine();">Add</button>
                <button type="button" class="btn btn-link ml-auto text-danger" data-dismiss="modal" onclick="inventoryFunctions.resetFields();">Close</button>
            </div>
        </div>
    </div>
</div>