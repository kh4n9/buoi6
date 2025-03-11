<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Reject Thesis Topic</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Topic Details
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Thesis Topic</h5>
            </div>
            <div class="card-body">
                <h4><?= htmlspecialchars($thesis['TenDeTai']) ?></h4>
                <p class="text-muted">Submitted by: <?= htmlspecialchars($thesis['SinhVienID']) ?> on <?= htmlspecialchars($thesis['NgayNop']) ?></p>
                
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle"></i> You are about to reject this thesis topic. Please provide a reason for the rejection.
                </div>
                
                <form action="<?= BASE_URL ?>detai/reject/<?= $thesis['DeTaiID'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="ghiChu" class="form-label">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="ghiChu" name="ghiChu" rows="4" required></textarea>
                        <div class="form-text">Provide clear feedback to help the student understand why the topic was rejected.</div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Reject Thesis Topic
                        </button>
                        <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Description</h5>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <?= nl2br(htmlspecialchars($thesis['MoTa'])) ?>
                </div>
            </div>
        </div>
    </div>
</div>
