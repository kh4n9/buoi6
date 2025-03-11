<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Lecturer Profile</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>giangvien/index" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
        <a href="<?= BASE_URL ?>giangvien/edit/<?= $giangVien['GiangVienID'] ?>" class="btn btn-sm btn-outline-primary ms-2">
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
                        <td><?= htmlspecialchars($giangVien['HoTen']) ?></td>
                    </tr>
                    <tr>
                        <th>Lecturer ID</th>
                        <td><?= htmlspecialchars($giangVien['MaGiangVien']) ?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <td><?= htmlspecialchars($giangVien['BoMon']) ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?= htmlspecialchars($giangVien['Email']) ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?= $giangVien['SoDienThoai'] ? htmlspecialchars($giangVien['SoDienThoai']) : 'N/A' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <h5>Students Assigned</h5>
                <span class="badge bg-primary"><?= $totalStudents ?> students</span>
            </div>
            <div class="card-body">
                <?php if ($totalStudents > 0): ?>
                    <div class="text-end mb-3">
                        <a href="<?= BASE_URL ?>giangvien/assign" class="btn btn-sm btn-primary">
                            <i class="bi bi-person-plus"></i> Assign More Students
                        </a>
                    </div>
                <?php endif; ?>
                
                <?php if (count($students) > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Student ID</th>
                                    <th>Class</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($students as $student): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($student['HoTen']) ?></td>
                                        <td><?= htmlspecialchars($student['MaSinhVien']) ?></td>
                                        <td><?= htmlspecialchars($student['Lop']) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL ?>sinhvien/view/<?= $student['SinhVienID'] ?>" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <?php if ($totalPages > 1): ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm justify-content-center">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= BASE_URL ?>giangvien/view/<?= $giangVien['GiangVienID'] ?>?page=<?= $page-1 ?>">Previous</a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                        <a class="page-link" href="<?= BASE_URL ?>giangvien/view/<?= $giangVien['GiangVienID'] ?>?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $totalPages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?= BASE_URL ?>giangvien/view/<?= $giangVien['GiangVienID'] ?>?page=<?= $page+1 ?>">Next</a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info">
                        This lecturer has no assigned students yet.
                        <a href="<?= BASE_URL ?>giangvien/assign" class="alert-link">Assign students now</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
