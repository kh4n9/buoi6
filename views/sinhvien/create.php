<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Student</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>sinhvien/index" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>sinhvien/store" method="POST" class="row g-3">
            <div class="col-md-6">
                <label for="HoTen" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" required>
            </div>
            
            <div class="col-md-6">
                <label for="MaSinhVien" class="form-label">Student ID <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="MaSinhVien" name="MaSinhVien" required>
            </div>
            
            <div class="col-md-6">
                <label for="NgaySinh" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" required>
            </div>
            
            <div class="col-md-6">
                <label for="Lop" class="form-label">Class <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="Lop" name="Lop" required>
            </div>
            
            <div class="col-md-6">
                <label for="Email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="Email" name="Email" required>
            </div>
            
            <div class="col-md-6">
                <label for="SoDienThoai" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="SoDienThoai" name="SoDienThoai">
            </div>
            
            <div class="col-md-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="createAccount" name="createAccount" value="1" checked>
                    <label class="form-check-label" for="createAccount">Create user account</label>
                </div>
            </div>
            
            <div class="col-md-6 account-fields">
                <label for="Username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="Username" name="Username">
                <div class="form-text">Choose a username for this student to login with.</div>
            </div>
            
            <div class="col-md-6 account-fields">
                <label for="Password" class="form-label">Password</label>
                <input type="text" class="form-control" id="Password" name="Password">
                <div class="form-text">Leave empty to use Student ID as default password.</div>
            </div>
            
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?= BASE_URL ?>sinhvien/index" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const createAccountCheckbox = document.getElementById('createAccount');
    const accountFields = document.querySelectorAll('.account-fields');
    
    function toggleAccountFields() {
        const display = createAccountCheckbox.checked ? 'block' : 'none';
        accountFields.forEach(field => {
            field.style.display = display;
        });
    }
    
    // Initial toggle
    toggleAccountFields();
    
    // Listen for changes
    createAccountCheckbox.addEventListener('change', toggleAccountFields);
});
</script>
