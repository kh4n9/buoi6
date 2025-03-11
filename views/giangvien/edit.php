<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Lecturer</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>giangvien/index" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>giangvien/update/<?= $giangVien['GiangVienID'] ?>" method="POST" class="row g-3">
            <div class="col-md-6">
                <label for="HoTen" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" value="<?= htmlspecialchars($giangVien['HoTen']) ?>" required>
            </div>
            
            <div class="col-md-6">
                <label for="MaGiangVien" class="form-label">Lecturer ID <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="MaGiangVien" name="MaGiangVien" value="<?= htmlspecialchars($giangVien['MaGiangVien']) ?>" required>
            </div>
            
            <div class="col-md-6">
                <label for="Email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="Email" name="Email" value="<?= htmlspecialchars($giangVien['Email']) ?>" required>
            </div>
            
            <div class="col-md-6">
                <label for="SoDienThoai" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="SoDienThoai" name="SoDienThoai" value="<?= htmlspecialchars($giangVien['SoDienThoai'] ?? '') ?>">
            </div>
            
            <div class="col-md-12">
                <label for="BoMon" class="form-label">Department <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="BoMon" name="BoMon" value="<?= htmlspecialchars($giangVien['BoMon']) ?>" required>
            </div>
            
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= BASE_URL ?>giangvien/index" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
