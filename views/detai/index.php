<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Thesis Topics</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <?php if ($_SESSION['user']['Role'] === ROLE_STUDENT): ?>
            <a href="<?= BASE_URL ?>detai/create" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-plus"></i> Submit New Topic
            </a>
        <?php endif; ?>
        
        <?php if (in_array($_SESSION['user']['Role'], [ROLE_DEPT_HEAD, ROLE_ADMIN])): ?>
            <div class="btn-group me-2">
                <a href="<?= BASE_URL ?>detai/index" class="btn btn-sm btn-outline-secondary <?= !isset($_GET['status']) ? 'active' : '' ?>">All</a>
                <a href="<?= BASE_URL ?>detai/index?status=Pending" class="btn btn-sm btn-outline-warning <?= isset($_GET['status']) && $_GET['status'] === 'Pending' ? 'active' : '' ?>">Pending</a>
                <a href="<?= BASE_URL ?>detai/index?status=Approved" class="btn btn-sm btn-outline-success <?= isset($_GET['status']) && $_GET['status'] === 'Approved' ? 'active' : '' ?>">Approved</a>
                <a href="<?= BASE_URL ?>detai/index?status=Rejected" class="btn btn-sm btn-outline-danger <?= isset($_GET['status']) && $_GET['status'] === 'Rejected' ? 'active' : '' ?>">Rejected</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($_SESSION['user']['Role'] === ROLE_STUDENT): ?>
    <!-- Student view of their own thesis topics -->
    <div class="card">
        <div class="card-header">
            <h5>My Thesis Topics</h5>
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
                                        <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-primary">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    You haven't submitted any thesis topics yet.
                    <a href="<?= BASE_URL ?>detai/create" class="btn btn-primary mt-2">Submit New Topic</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php elseif ($_SESSION['user']['Role'] === ROLE_LECTURER): ?>
    <!-- Lecturer view of thesis topics -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Student Thesis Topics</h5>
            <p class="text-muted mb-0">Topics submitted by students assigned to you</p>
        </div>
        <div class="card-body">
            <?php if (count($theses) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th>Student</th>
                                <th>Student ID</th>
                                <th>Status</th>
                                <th>Submission Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($theses as $thesis): ?>
                                <tr>
                                    <td><?= htmlspecialchars($thesis['TenDeTai']) ?></td>
                                    <td><?= htmlspecialchars($thesis['TenSinhVien']) ?></td>
                                    <td><?= htmlspecialchars($thesis['MaSinhVien']) ?></td>
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
                                    <td>
                                        <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-primary">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    Your assigned students haven't submitted any thesis topics yet.
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php else: ?>
    <!-- Department Head or Admin view with all thesis topics and filtering -->
    <div class="card">
        <div class="card-header bg-light">
            <strong>Total Topics: <?= $totalTheses ?></strong>
            <?php if (isset($_GET['status'])): ?>
                <span class="badge <?= $_GET['status'] === 'Pending' ? 'bg-warning' : ($_GET['status'] === 'Approved' ? 'bg-success' : 'bg-danger') ?> ms-2">
                    Filter: <?= htmlspecialchars($_GET['status']) ?>
                </span>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?php if (count($theses) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Topic</th>
                                <th>Student</th>
                                <th>Status</th>
                                <th>Submission Date</th>
                                <th>Advisor</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($theses as $index => $thesis): ?>
                                <tr>
                                    <td><?= (($page - 1) * 10) + $index + 1 ?></td>
                                    <td><?= htmlspecialchars($thesis['TenDeTai']) ?></td>
                                    <td>
                                        <?= htmlspecialchars($thesis['TenSinhVien']) ?><br>
                                        <small class="text-muted"><?= htmlspecialchars($thesis['MaSinhVien']) ?></small>
                                    </td>
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
                                    <td><?= isset($thesis['TenGiangVien']) ? htmlspecialchars($thesis['TenGiangVien']) : 'Not assigned' ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        
                                        <?php if ($thesis['TrangThai'] === 'Pending' && $_SESSION['user']['Role'] === ROLE_DEPT_HEAD): ?>
                                            <a href="<?= BASE_URL ?>detai/approve/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-success">
                                                <i class="bi bi-check-circle"></i> Approve
                                            </a>
                                            <a href="<?= BASE_URL ?>detai/reject/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-danger">
                                                <i class="bi bi-x-circle"></i> Reject
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BASE_URL ?>detai/index?page=<?= $page-1 ?><?= isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>detai/index?page=<?= $i ?><?= isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BASE_URL ?>detai/index?page=<?= $page+1 ?><?= isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '' ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
                
            <?php else: ?>
                <div class="alert alert-info">
                    No thesis topics found. <?php if (isset($_GET['status'])): ?><a href="<?= BASE_URL ?>detai/index">Clear filter</a><?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
