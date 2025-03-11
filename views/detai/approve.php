<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Approve Thesis Topic</h1>
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
                
                <div class="alert alert-warning">
                    <i class="bi bi-info-circle"></i> You are about to approve this thesis topic. Please assign an advisor to supervise this thesis.
                </div>
                
                <form action="<?= BASE_URL ?>detai/approve/<?= $thesis['DeTaiID'] ?>" method="POST">
                    <div class="mb-3">
                        <label for="giangVienID" class="form-label">Select Advisor <span class="text-danger">*</span></label>
                        <select class="form-select" id="giangVienID" name="giangVienID" required>
                            <option value="">-- Select an Advisor --</option>
                            <?php foreach ($lecturers as $lecturer): ?>
                                <option value="<?= $lecturer['GiangVienID'] ?>">
                                    <?= htmlspecialchars($lecturer['MaGiangVien']) ?> - 
                                    <?= htmlspecialchars($lecturer['HoTen']) ?> 
                                    (<?= htmlspecialchars($lecturer['BoMon']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Approve and Assign
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
