<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Students</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>sinhvien/create" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus"></i> Add New Student
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="<?= BASE_URL ?>sinhvien/index" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" class="form-control" name="search" placeholder="Search by name, student ID or email..." value="<?= isset($search) ? htmlspecialchars($search) : '' ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <strong>Total Students: <?= $totalStudents ?></strong>
    </div>
    <div class="card-body">
        <?php if (count($sinhviens) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Class</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sinhviens as $index => $sv): ?>
                            <tr>
                                <td><?= (($page - 1) * 10) + $index + 1 ?></td>
                                <td><?= htmlspecialchars($sv['HoTen']) ?></td>
                                <td><?= htmlspecialchars($sv['MaSinhVien']) ?></td>
                                <td><?= htmlspecialchars($sv['Lop']) ?></td>
                                <td><?= htmlspecialchars($sv['Email']) ?></td>
                                <td><?= $sv['SoDienThoai'] ? htmlspecialchars($sv['SoDienThoai']) : 'N/A' ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>sinhvien/view/<?= $sv['SinhVienID'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="<?= BASE_URL ?>sinhvien/edit/<?= $sv['SinhVienID'] ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="<?= BASE_URL ?>sinhvien/delete/<?= $sv['SinhVienID'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">
                                        <i class="bi bi-trash"></i> Delete
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
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= BASE_URL ?>sinhvien/index?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">Previous</a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?= BASE_URL ?>sinhvien/index?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= BASE_URL ?>sinhvien/index?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="alert alert-info">
                No students found. <?php if (!empty($search)): ?><a href="<?= BASE_URL ?>sinhvien/index">Clear search</a><?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
