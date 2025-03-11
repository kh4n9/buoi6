<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Thesis Topic Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>detai/index" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Topics
        </a>
        
        <?php
        // Check if user has permission to edit this thesis
        $canEdit = false;
        $user = $_SESSION['user'];
        
        if (in_array($user['Role'], [ROLE_ADMIN, ROLE_DEPT_HEAD])) {
            $canEdit = true;
        } elseif ($user['Role'] === ROLE_LECTURER) {
            require_once 'models/DeTai.php';
            $deTaiModel = new DeTai($this->pdo);
            if ($deTaiModel->isLecturerAssigned($thesis['DeTaiID'], $user['GiangVienID']) || 
                $deTaiModel->isLecturerAdvisor($thesis['DeTaiID'], $user['GiangVienID'])) {
                $canEdit = true;
            }
        }
        ?>
        
        <?php if ($canEdit): ?>
            <a href="<?= BASE_URL ?>detai/edit/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-outline-primary ms-2">
                <i class="bi bi-pencil"></i> Edit Thesis
            </a>
        <?php endif; ?>
        
        <?php if ($_SESSION['user']['Role'] === ROLE_DEPT_HEAD && $thesis['TrangThai'] === 'Pending'): ?>
            <div class="btn-group ms-2">
                <a href="<?= BASE_URL ?>detai/approve/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-success">
                    <i class="bi bi-check-circle"></i> Approve
                </a>
                <a href="<?= BASE_URL ?>detai/reject/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-danger">
                    <i class="bi bi-x-circle"></i> Reject
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Thesis Information</h5>
                <div>
                    <?php if ($thesis['TrangThai'] === 'Pending'): ?>
                        <span class="badge bg-warning">Pending</span>
                    <?php elseif ($thesis['TrangThai'] === 'Approved'): ?>
                        <span class="badge bg-success">Approved</span>
                    <?php else: ?>
                        <span class="badge bg-danger">Rejected</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <h4><?= htmlspecialchars($thesis['TenDeTai']) ?></h4>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <p><strong>Submission Date:</strong> <?= htmlspecialchars($thesis['NgayNop']) ?></p>
                        <p><strong>Status:</strong> 
                            <?php if ($thesis['TrangThai'] === 'Pending'): ?>
                                <span class="badge bg-warning">Pending</span>
                            <?php elseif ($thesis['TrangThai'] === 'Approved'): ?>
                                <span class="badge bg-success">Approved</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Rejected</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Approval Date:</strong> <?= $thesis['NgayDuyet'] ? htmlspecialchars($thesis['NgayDuyet']) : 'N/A' ?></p>
                        <?php if ($thesis['TrangThai'] === 'Rejected' && $thesis['GhiChu']): ?>
                            <p><strong>Rejection Reason:</strong> <?= htmlspecialchars($thesis['GhiChu']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <hr>
                
                <h5>Description</h5>
                <div class="mb-4">
                    <?= nl2br(htmlspecialchars($thesis['MoTa'])) ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Student Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> <?= htmlspecialchars($student['HoTen']) ?></p>
                <p><strong>Student ID:</strong> <?= htmlspecialchars($student['MaSinhVien']) ?></p>
                <p><strong>Class:</strong> <?= htmlspecialchars($student['Lop']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($student['Email']) ?></p>
                
                <?php if ($student['SoDienThoai']): ?>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($student['SoDienThoai']) ?></p>
                <?php endif; ?>
                
                <div class="mt-2">
                    <a href="<?= BASE_URL ?>sinhvien/view/<?= $student['SinhVienID'] ?>" class="btn btn-sm btn-info">
                        <i class="bi bi-person"></i> View Profile
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Advisor Information</h5>
            </div>
            <div class="card-body">
                <?php if ($advisor): ?>
                    <p><strong>Name:</strong> <?= htmlspecialchars($advisor['HoTen']) ?></p>
                    <p><strong>Department:</strong> <?= htmlspecialchars($advisor['BoMon']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($advisor['Email']) ?></p>
                    
                    <?php if ($advisor['SoDienThoai']): ?>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($advisor['SoDienThoai']) ?></p>
                    <?php endif; ?>
                    
                    <div class="mt-2">
                        <a href="<?= BASE_URL ?>giangvien/view/<?= $advisor['GiangVienID'] ?>" class="btn btn-sm btn-info">
                            <i class="bi bi-person"></i> View Profile
                        </a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        No advisor assigned yet.
                        
                        <?php if ($_SESSION['user']['Role'] === ROLE_DEPT_HEAD && $thesis['TrangThai'] === 'Pending'): ?>
                            <div class="mt-2">
                                <a href="<?= BASE_URL ?>detai/approve/<?= $thesis['DeTaiID'] ?>" class="btn btn-success">Approve & Assign Advisor</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if ($canEdit && $thesis['TrangThai'] !== 'Pending'): ?>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Change Status</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>detai/changeStatus/<?= $thesis['DeTaiID'] ?>" method="POST" class="row">
                        <div class="col-md-4">
                            <label for="status" class="form-label">New Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Pending" <?= $thesis['TrangThai'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="Approved" <?= $thesis['TrangThai'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
                                <option value="Rejected" <?= $thesis['TrangThai'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label for="ghiChu" class="form-label">Notes/Comments</label>
                            <input type="text" class="form-control" id="ghiChu" name="ghiChu" value="<?= htmlspecialchars($thesis['GhiChu'] ?? '') ?>">
                        </div>
                        
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
