<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Student Profile</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>sinhvien/index" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
        <a href="<?= BASE_URL ?>sinhvien/edit/<?= $sinhVien['SinhVienID'] ?>" class="btn btn-sm btn-outline-primary ms-2">
            <i class="bi bi-pencil"></i> Edit
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Personal Information</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th style="width: 30%">Full Name</th>
                        <td><?= htmlspecialchars($sinhVien['HoTen']) ?></td>
                    </tr>
                    <tr>
                        <th>Student ID</th>
                        <td><?= htmlspecialchars($sinhVien['MaSinhVien']) ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?= htmlspecialchars($sinhVien['NgaySinh']) ?></td>
                    </tr>
                    <tr>
                        <th>Class</th>
                        <td><?= htmlspecialchars($sinhVien['Lop']) ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= htmlspecialchars($sinhVien['Email']) ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?= $sinhVien['SoDienThoai'] ? htmlspecialchars($sinhVien['SoDienThoai']) : 'N/A' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Advisor Information</h5>
            </div>
            <div class="card-body">
                <?php if ($advisor): ?>
                    <table class="table">
                        <tr>
                            <th style="width: 30%">Name</th>
                            <td><?= htmlspecialchars($advisor['HoTen']) ?></td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td><?= htmlspecialchars($advisor['BoMon']) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= htmlspecialchars($advisor['Email']) ?></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><?= $advisor['SoDienThoai'] ? htmlspecialchars($advisor['SoDienThoai']) : 'N/A' ?></td>
                        </tr>
                        <tr>
                            <th>Start Date</th>
                            <td><?= htmlspecialchars($advisor['NgayBatDau']) ?></td>
                        </tr>
                        <tr>
                            <th>Notes</th>
                            <td><?= $advisor['GhiChu'] ? htmlspecialchars($advisor['GhiChu']) : 'N/A' ?></td>
                        </tr>
                    </table>
                <?php else: ?>
                    <div class="alert alert-warning">
                        No advisor assigned yet. 
                        <a href="<?= BASE_URL ?>giangvien/assign" class="alert-link">Assign an advisor</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Thesis Topics</h5>
    </div>
    <div class="card-body">
        <?php if (count($theses) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Topic</th>
                            <th>Status</th>
                            <th>Submission Date</th>
                            <th>Approval Date</th>
                            <th>Advisor</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($theses as $thesis): ?>
                            <tr>
                                <td><?= htmlspecialchars($thesis['TenDeTai']) ?></td>
                                <td>
                                    <?php if ($thesis['TrangThai'] === 'Pending'): ?>
                                        <span class="badge bg-warning">Pending</span>
                                    <?php elseif ($thesis['TrangThai'] === 'Approved'): ?>
                                        <span class="badge bg-success">Approved</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Rejected</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($thesis['NgayNop']) ?></td>
                                <td><?= $thesis['NgayDuyet'] ? htmlspecialchars($thesis['NgayDuyet']) : 'N/A' ?></td>
                                <td><?= isset($thesis['TenGiangVien']) ? htmlspecialchars($thesis['TenGiangVien']) : 'Not assigned' ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                This student hasn't submitted any thesis topics yet.
            </div>
        <?php endif; ?>
    </div>
</div>
