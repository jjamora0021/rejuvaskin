<!-- Delete Modal -->
<div class="modal fade" id="delete-patient-modal" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-secondary" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-black" id="exampleModalLabel">Delete Patient Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="text-black">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-success d-none" role="alert">
                    <strong>Patient information successfully deleted.</strong>
                </div>
                <div class="alert alert-danger d-none" role="alert">
                    <strong>Patient information failed to be deleted.</strong>
                </div>
                <div class="form-group mb-0">
                    <label class="form-control-label d-block mb-3 text-danger">Do you really want to delete this patient record?</label>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>