<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<?php if ($user['Role'] === ROLE_STUDENT): ?>
    <!-- Student Dashboard -->
    <div class="card mb-4">
        <div class="card-header">
            <h4>My Advisor</h4>
        </div>
        <div class="card-body">
            <?php if (isset($data['advisor']) && $data['advisor']): ?>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> <?= htmlspecialchars($data['advisor']['HoTen']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($data['advisor']['Email']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($data['advisor']['SoDienThoai']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Department:</strong> <?= htmlspecialchars($data['advisor']['BoMon']) ?></p>
                        <p><strong>Start Date:</strong> <?= htmlspecialchars($data['advisor']['NgayBatDau']) ?></p>
                        <?php if ($data['advisor']['GhiChu']): ?>
                            <p><strong>Notes:</strong> <?= htmlspecialchars($data['advisor']['GhiChu']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <p class="alert alert-warning">You have not been assigned to an advisor yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>My Thesis Topics</h4>
        </div>
        <div class="card-body">
            <?php if (isset($data['theses']) && count($data['theses']) > 0): ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Topic</th>
                            <th>Status</th>
                            <th>Submission Date</th>
                            <th>Advisor</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['theses'] as $thesis): ?>
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
                                <td><?= isset($thesis['TenGiangVien']) ? htmlspecialchars($thesis['TenGiangVien']) : 'Not assigned' ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-primary">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="alert alert-info">You haven't submitted any thesis topics yet.</p>
                <a href="<?= BASE_URL ?>detai/create" class="btn btn-primary">Submit New Topic</a>
            <?php endif; ?>
        </div>
    </div>

<?php elseif ($user['Role'] === ROLE_LECTURER): ?>
    <!-- Lecturer Dashboard -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Students Assigned to Me</h4>
            <span class="badge bg-primary"><?= $data['totalStudents'] ?> students</span>
        </div>
        <div class="card-body">
            <?php if (isset($data['students']) && count($data['students']) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Student ID</th>
                                <th>Class</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['students'] as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['HoTen']) ?></td>
                                    <td><?= htmlspecialchars($student['MaSinhVien']) ?></td>
                                    <td><?= htmlspecialchars($student['Lop']) ?></td>
                                    <td><?= htmlspecialchars($student['Email']) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>sinhvien/view/<?= $student['SinhVienID'] ?>" class="btn btn-sm btn-primary">View Profile</a>
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
                                    <a class="page-link" href="<?= BASE_URL ?>dashboard/index?page=<?= $page-1 ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>dashboard/index?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BASE_URL ?>dashboard/index?page=<?= $page+1 ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else: ?>
                <p class="alert alert-info">You don't have any students assigned to you yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Thesis Topics I'm Supervising</h4>
                </div>
                <div class="card-body">
                    <?php if (isset($data['assignedTheses']) && count($data['assignedTheses']) > 0): ?>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Topic</th>
                                    <th>Student</th>
                                    <th>Student ID</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($data['assignedTheses'] as $thesis): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($thesis['TenDeTai']) ?></td>
                                        <td><?= htmlspecialchars($thesis['TenSinhVien']) ?></td>
                                        <td><?= htmlspecialchars($thesis['MaSinhVien']) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-primary">View</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="alert alert-info">You don't have any thesis topics assigned to you yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Student Thesis Topics</h4>
                    <?php if ($data['pendingCount'] > 0): ?>
                        <span class="badge bg-warning"><?= $data['pendingCount'] ?> pending review</span>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <?php if (isset($data['studentTheses']) && count($data['studentTheses']) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Topic</th>
                                        <th>Student</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($data['studentTheses'] as $thesis): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($thesis['TenDeTai']) ?></td>
                                            <td><?= htmlspecialchars($thesis['TenSinhVien']) ?></td>
                                            <td>
                                                <?php if ($thesis['TrangThai'] === 'Pending'): ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                <?php elseif ($thesis['TrangThai'] === 'Approved'): ?>
                                                    <span class="badge bg-success">Approved</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Rejected</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="alert alert-info">Your students haven't submitted any thesis topics yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php elseif ($user['Role'] === ROLE_DEPT_HEAD): ?>
    <!-- Department Head Dashboard -->
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Pending Thesis Topics</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $data['totalPendingTheses'] ?></h5>
                    <p class="card-text">Thesis topics awaiting approval</p>
                    <a href="<?= BASE_URL ?>detai/index?status=Pending" class="btn btn-light btn-sm">View All</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Unassigned Students</div>
                <div class="card-body">
                    <h5 class="card-title"><?= count($data['unassignedStudents']) ?></h5>
                    <p class="card-text">Students without advisors</p>
                    <a href="<?= BASE_URL ?>giangvien/assign" class="btn btn-light btn-sm">Assign Now</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Assignments</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $data['assignmentStats'] ?></h5>
                    <p class="card-text">Student-advisor pairings</p>
                    <a href="<?= BASE_URL ?>giangvien/assignments" class="btn btn-light btn-sm">View All</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h4>Recent Pending Thesis Topics</h4>
        </div>
        <div class="card-body">
            <?php if (isset($data['pendingTheses']) && count($data['pendingTheses']) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th>Student</th>
                                <th>Student ID</th>
                                <th>Submission Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['pendingTheses'] as $thesis): ?>
                                <tr>
                                    <td><?= htmlspecialchars($thesis['TenDeTai']) ?></td>
                                    <td><?= htmlspecialchars($thesis['TenSinhVien']) ?></td>
                                    <td><?= htmlspecialchars($thesis['MaSinhVien']) ?></td>
                                    <td><?= htmlspecialchars($thesis['NgayNop']) ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>detai/view/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-primary">View</a>
                                        <a href="<?= BASE_URL ?>detai/approve/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-success">Approve</a>
                                        <a href="<?= BASE_URL ?>detai/reject/<?= $thesis['DeTaiID'] ?>" class="btn btn-sm btn-danger">Reject</a>
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
                                    <a class="page-link" href="<?= BASE_URL ?>dashboard/index?page=<?= $page-1 ?>">Previous</a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= BASE_URL ?>dashboard/index?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= BASE_URL ?>dashboard/index?page=<?= $page+1 ?>">Next</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else: ?>
                <p class="alert alert-success">No pending thesis topics.</p>
            <?php endif; ?>
        </div>
    </div>

<?php elseif ($user['Role'] === ROLE_ADMIN): ?>
    <!-- Administrator Dashboard -->
    <div class="row">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Students</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $data['studentCount'] ?></h5>
                    <p class="card-text">Total students</p>
                    <a href="<?= BASE_URL ?>sinhvien/index" class="btn btn-light btn-sm">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Lecturers</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $data['lecturerCount'] ?></h5>
                    <p class="card-text">Total lecturers</p>
                    <a href="<?= BASE_URL ?>giangvien/index" class="btn btn-light btn-sm">Manage</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Approved Theses</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $data['approvedTheses'] ?></h5>
                    <p class="card-text">Approved topics</p>
                    <a href="<?= BASE_URL ?>detai/index?status=Approved" class="btn btn-light btn-sm">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Pending Theses</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $data['pendingTheses'] ?></h5>
                    <p class="card-text">Pending topics</p>
                    <a href="<?= BASE_URL ?>detai/index?status=Pending" class="btn btn-light btn-sm">View</a>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>System Users</h4>
            <div>
                <a href="#" class="btn btn-sm btn-primary">Add New User</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['users'] as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['Username']) ?></td>
                                <td><?= htmlspecialchars($user['Role']) ?></td>
                                <td><?= htmlspecialchars($user['CreatedAt']) ?></td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
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
                                <a class="page-link" href="<?= BASE_URL ?>dashboard/index?page=<?= $page-1 ?>">Previous</a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?= BASE_URL ?>dashboard/index?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= BASE_URL ?>dashboard/index?page=<?= $page+1 ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
