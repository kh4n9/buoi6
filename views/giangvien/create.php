<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Add New Lecturer</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= BASE_URL ?>giangvien/index" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= BASE_URL ?>giangvien/store" method="POST" class="row g-3">
            <div class="col-md-6">
                <label for="HoTen" class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="HoTen" name="HoTen" required>
            </div>
            
            <div class="col-md-6">
                <label for="MaGiangVien" class="form-label">Lecturer ID <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="MaGiangVien" name="MaGiangVien" required>
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
                <label for="BoMon" class="form-label">Department <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="BoMon" name="BoMon" required>
            </div>
            
            <div class="col-md-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="createAccount" name="createAccount" value="1" checked>
                    <label class="form-check-label" for="createAccount">Create user account</label>
                </div>
                <small class="form-text text-muted">If checked, a user account will be created with the lecturer ID as both username and password.</small>
            </div>
            
            <div class="col-md-6 account-fields">
                <label for="Username" class="form-label">Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="Username" name="Username">
                <div class="form-text">Choose a username for this lecturer to login with.</div>
            </div>
            
            <div class="col-md-6 account-fields">
                <label for="Password" class="form-label">Password</label>
                <input type="text" class="form-control" id="Password" name="Password">
                <div class="form-text">Leave empty to use Lecturer ID as default password.</div>
            </div>
            
            <div class="col-md-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="isHeadOfDepartment" name="isHeadOfDepartment" value="1">
                    <label class="form-check-label" for="isHeadOfDepartment">Head of Department</label>
                </div>
                <small class="form-text text-muted">If checked, this lecturer will have department head privileges.</small>
            </div>
            
            <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?= BASE_URL ?>giangvien/index" class="btn btn-secondary">Cancel</a>
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
