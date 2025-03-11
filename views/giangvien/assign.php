<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Assign Student to Advisor</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>giangvien/assignments" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-list-check"></i> View All Assignments
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <?php if (empty($students)): ?>
            <div class="alert alert-info">
                <h5>No Unassigned Students</h5>
                <p>All students have been assigned to advisors.</p>
                <a href="<?= BASE_URL ?>sinhvien/create" class="btn btn-primary">Add New Student</a>
            </div>
        <?php else: ?>
            <div class="card">
                <div class="card-header">
                    <h5>Assign Advisor</h5>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>giangvien/assign" method="POST">
                        <div class="row mb-3">
                            <label for="sinhVienID" class="col-sm-2 col-form-label">Student</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="sinhVienID" name="sinhVienID" required>
                                    <option value="">-- Select Student --</option>
                                    <?php foreach ($students as $student): ?>
                                        <option value="<?= $student['SinhVienID'] ?>">
                                            <?= htmlspecialchars($student['MaSinhVien']) ?> - 
                                            <?= htmlspecialchars($student['HoTen']) ?> 
                                            (<?= htmlspecialchars($student['Lop']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="giangVienID" class="col-sm-2 col-form-label">Advisor</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="giangVienID" name="giangVienID" required>
                                    <option value="">-- Select Advisor --</option>
                                    <?php foreach ($lecturers as $lecturer): ?>
                                        <option value="<?= $lecturer['GiangVienID'] ?>">
                                            <?= htmlspecialchars($lecturer['MaGiangVien']) ?> - 
                                            <?= htmlspecialchars($lecturer['HoTen']) ?> 
                                            (<?= htmlspecialchars($lecturer['BoMon']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="ghiChu" class="col-sm-2 col-form-label">Notes</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="ghiChu" name="ghiChu" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-10 offset-sm-2">
                                <button type="submit" class="btn btn-primary">Assign</button>
                                <a href="<?= BASE_URL ?>giangvien/assignments" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
