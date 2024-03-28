<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
    Basic Modal
</button>
<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable {{size}}">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Basic Modal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{body}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div><!-- End Basic Modal-->