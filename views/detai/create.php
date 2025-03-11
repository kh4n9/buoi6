<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Submit New Thesis Topic</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>detai/index" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Topics
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Thesis Topic Details</h5>
    </div>
    <div class="card-body">
        <form action="<?= BASE_URL ?>detai/store" method="POST">
            <div class="mb-3">
                <label for="TenDeTai" class="form-label">Topic Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="TenDeTai" name="TenDeTai" required>
            </div>
            
            <div class="mb-3">
                <label for="MoTa" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="MoTa" name="MoTa" rows="5" required></textarea>
                <div class="form-text">Provide a detailed description of your thesis topic.</div>
            </div>
            
            <div class="alert alert-info">
                <strong>Note:</strong> Your submission will be reviewed by the department head. You will be notified when it's approved and assigned to an advisor.
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?= BASE_URL ?>detai/index" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
