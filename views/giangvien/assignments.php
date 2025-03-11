<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Student-Advisor Assignments</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>giangvien/assign" class="btn btn-sm btn-outline-primary">
            <i class="bi bi-person-plus"></i> Create New Assignment
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header bg-light">
        <strong>Total Assignments: <?= $totalAssignments ?></strong>
    </div>
    <div class="card-body">
        <?php if (count($assignments) > 0): ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Student ID</th>
                            <th>Advisor</th>
                            <th>Department</th>
                            <th>Start Date</th>
                            <th>Notes</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($assignments as $index => $assignment): ?>
                            <tr>
                                <td><?= (($page - 1) * 10) + $index + 1 ?></td>
                                <td><?= htmlspecialchars($assignment['TenSinhVien']) ?></td>
                                <td><?= htmlspecialchars($assignment['MaSinhVien']) ?></td>
                                <td><?= htmlspecialchars($assignment['TenGiangVien']) ?></td>
                                <td><?= htmlspecialchars($assignment['MaGiangVien']) ?></td>
                                <td><?= htmlspecialchars($assignment['NgayBatDau']) ?></td>
                                <td><?= $assignment['GhiChu'] ? htmlspecialchars($assignment['GhiChu']) : 'N/A' ?></td>
                                <td>
                                    <a href="<?= BASE_URL ?>sinhvien/view/<?= $assignment['SinhVienID'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-person"></i> Student
                                    </a>
                                    <a href="<?= BASE_URL ?>giangvien/view/<?= $assignment['GiangVienID'] ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-person-workspace"></i> Advisor
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
                                <a class="page-link" href="<?= BASE_URL ?>giangvien/assignments?page=<?= $page-1 ?>">Previous</a>
                            </li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="<?= BASE_URL ?>giangvien/assignments?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="<?= BASE_URL ?>giangvien/assignments?page=<?= $page+1 ?>">Next</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <div class="alert alert-info">
                No assignments found. <a href="<?= BASE_URL ?>giangvien/assign">Create your first assignment</a>
            </div>
        <?php endif; ?>
    </div>
</div>
