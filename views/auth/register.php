<div class="login-container" style="max-width: 600px;">
    <div class="site-header">
        <h1><?= SITE_NAME ?></h1>
        <p class="lead">Student Registration</p>
    </div>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php endif; ?>
    
    <form method="POST" action="<?= BASE_URL ?>auth/register" class="row g-3">
        <div class="col-md-6">
            <label for="HoTen" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="HoTen" name="HoTen" required>
        </div>
        <div class="col-md-6">
            <label for="MaSinhVien" class="form-label">Student ID</label>
            <input type="text" class="form-control" id="MaSinhVien" name="MaSinhVien" required>
        </div>
        <div class="col-md-6">
            <label for="NgaySinh" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="NgaySinh" name="NgaySinh" required>
        </div>
        <div class="col-md-6">
            <label for="Lop" class="form-label">Class</label>
            <input type="text" class="form-control" id="Lop" name="Lop" required>
        </div>
        <div class="col-md-6">
            <label for="Email" class="form-label">Email</label>
            <input type="email" class="form-control" id="Email" name="Email" required>
        </div>
        <div class="col-md-6">
            <label for="SoDienThoai" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="SoDienThoai" name="SoDienThoai">
        </div>
        <div class="col-md-6">
            <label for="Username" class="form-label">Username</label>
            <input type="text" class="form-control" id="Username" name="Username" required>
        </div>
        <div class="col-md-6">
            <label for="Password" class="form-label">Password</label>
            <input type="password" class="form-control" id="Password" name="Password" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </div>
        <div class="col-12 text-center">
            <a href="<?= BASE_URL ?>auth/login">Already have an account? Login</a>
        </div>
    </form>
</div>
