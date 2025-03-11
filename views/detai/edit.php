<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Thesis Topic</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Details
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Edit Thesis Information</h5>
    </div>
    <div class="card-body">
        <form action="<?= BASE_URL ?>detai/update/<?= $thesis['DeTaiID'] ?>" method="POST">
            <div class="mb-3">
                <label for="TenDeTai" class="form-label">Topic Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="TenDeTai" name="TenDeTai" value="<?= htmlspecialchars($thesis['TenDeTai']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label for="MoTa" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control" id="MoTa" name="MoTa" rows="5" required><?= htmlspecialchars($thesis['MoTa']) ?></textarea>
            </div>
            
            <?php if (in_array($_SESSION['user']['Role'], [ROLE_ADMIN, ROLE_DEPT_HEAD])): ?>
                <div class="mb-3">
                    <label for="TrangThai" class="form-label">Status</label>
                    <select class="form-select" id="TrangThai" name="TrangThai">
                        <option value="Pending" <?= $thesis['TrangThai'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Approved" <?= $thesis['TrangThai'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
                        <option value="Rejected" <?= $thesis['TrangThai'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>
                
                <?php if ($_SESSION['user']['Role'] === ROLE_ADMIN): ?>
                    <div class="mb-3">
                        <label for="GiangVienID" class="form-label">Assigned Lecturer</label>
                        <select class="form-select" id="GiangVienID" name="GiangVienID">
                            <option value="">None</option>
                            <?php 
                            // Load all lecturers for selection
                            require_once 'models/GiangVien.php';
                            $giangVienModel = new GiangVien($this->pdo);
                            $lecturers = $giangVienModel->getAll();
                            foreach ($lecturers as $lecturer): 
                            ?>
                                <option value="<?= $lecturer['GiangVienID'] ?>" <?= $thesis['GiangVienID'] == $lecturer['GiangVienID'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($lecturer['MaGiangVien'] . ' - ' . $lecturer['HoTen']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
