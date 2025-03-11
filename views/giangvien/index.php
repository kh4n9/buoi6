<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manage Lecturers</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>giangvien/create" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-plus"></i> Add New Lecturer
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="<?= BASE_URL ?>giangvien/index" method="GET" class="row g-3">
            <div class="col-md-10">
                <input type="text" class="form-control" name="search" placeholder="Search by name, ID, email or department..." value="<?= isset($search) ? htmlspecialchars($search) : '' ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <strong>Total Lecturers: <?= $totalLecturers ?></strong>
    </div>
    <div class="card-body">
        <?php if (count($giangviens) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Lecturer ID</th>
                            <th>Department</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($giangviens as $index => $gv): ?>
                            <tr>
                                <td><?= (($page - 1) * 10) + $index + 1 ?></td>
                                <td><?= htmlspecialchars($gv['HoTen']) ?></td>
                                <td><?= htmlspecialchars($gv['MaGiangVien']) ?></td>
                                <td><?= htmlspecialchars($gv['BoMon']) ?></td>
                                <td><?= htmlspecialchars($gv['Email']) ?></td>
                                <td><?= $gv['SoDienThoai'] ? htmlspecialchars($gv['SoDienThoai']) : 'N/A' ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>giangvien/view/<?= $gv['GiangVienID'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                    <a href="<?= BASE_URL ?>giangvien/edit/<?= $gv['GiangVienID'] ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <a href="<?= BASE_URL ?>giangvien/delete/<?= $gv['GiangVienID'] ?>" class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Are you sure you want to delete this lecturer?');">
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
                                <a class="page-link" href="<?= BASE_URL ?>giangvien/index?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">Previous</a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?= BASE_URL ?>giangvien/index?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= BASE_URL ?>giangvien/index?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
            
        <?php else: ?>
            <div class="alert alert-info">
                No lecturers found. <?php if (!empty($search)): ?><a href="<?= BASE_URL ?>giangvien/index">Clear search</a><?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
