<!-- Update Stocks Modal -->
<div class="modal fade" id="upload-medicine-modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
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
                    <strong>Please double check the Medicines on your excel file. One or more medicines already exist in the system.</strong>
                </div>
                <form action="{{ route('upload-medicine-list') }}" method="POST" id="add-medicine-form" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="before_image">Upload an Excel File</label>
                                    <input id="file" name="file" type="file" class="file" data-browse-on-zone-click="true" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-success new-event--add fileinput-upload fileinput-upload-button" id="add-btn" onclick="inventoryFunctions.uploadMedicine();">Add</button>
                <button type="button" class="btn btn-link ml-auto text-danger" data-dismiss="modal" onclick="inventoryFunctions.resetFields();">Close</button>
            </form>
            </div>
        </div>
    </div>
</div>
