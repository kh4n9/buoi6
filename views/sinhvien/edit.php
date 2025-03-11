<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Student</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>sinhvien/index" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>sinhvien/update/<?= $sinhVien['SinhVienID'] ?>" method="POST" class="row g-3">
            <div class="col-md-6">
                <label for="HoTen" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" value="<?= htmlspecialchars($sinhVien['HoTen']) ?>" required>
            </div>
            
            <div class="col-md-6">
                <label for="MaSinhVien" class="form-label">Student ID <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="MaSinhVien" name="MaSinhVien" value="<?= htmlspecialchars($sinhVien['MaSinhVien']) ?>" required>
            </div>
            
            <div class="col-md-6">
                <label for="NgaySinh" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" value="<?= htmlspecialchars($sinhVien['NgaySinh']) ?>" required>
            </div>
            
            <div class="col-md-6">
                <label for="Lop" class="form-label">Class <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="Lop" name="Lop" value="<?= htmlspecialchars($sinhVien['Lop']) ?>" required>
            </div>
            
            <div class="col-md-6">
                <label for="Email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="Email" name="Email" value="<?= htmlspecialchars($sinhVien['Email']) ?>" required>
            </div>
            
            <div class="col-md-6">
                <label for="SoDienThoai" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="SoDienThoai" name="SoDienThoai" value="<?= htmlspecialchars($sinhVien['SoDienThoai'] ?? '') ?>">
            </div>
            
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= BASE_URL ?>sinhvien/index" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
