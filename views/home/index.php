<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Thesis Advisor Management System</h1>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Students</div>
            <div class="card-body">
                <h5 class="card-title"><?= $totalStudents ?></h5>
                <p class="card-text">Total registered students</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Lecturers</div>
            <div class="card-body">
                <h5 class="card-title"><?= $totalLecturers ?></h5>
                <p class="card-text">Total academic advisors</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-info mb-3">
            <div class="card-header">Thesis Topics</div>
            <div class="card-body">
                <h5 class="card-title"><?= $totalTheses ?></h5>
                <p class="card-text">Total thesis topics registered</p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card text-white bg-warning mb-3">
            <div class="card-header">Pending</div>
            <div class="card-body">
                <h5 class="card-title"><?= $pendingTheses ?></h5>
                <p class="card-text">Thesis topics awaiting approval</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>About the System</h5>
            </div>
            <div class="card-body">
                <p>The Thesis Advisor Management System facilitates the management and tracking of thesis guidance activities between students and faculty members.</p>
                <p>It provides a structured platform to record student details, faculty advisors, and their interactions throughout the thesis advisory process.</p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Quick Links</h5>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><a href="<?= BASE_URL ?>dashboard/index">Dashboard</a></li>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['Role'] === ROLE_STUDENT): ?>
                    <li class="list-group-item"><a href="<?= BASE_URL ?>detai/create">Submit New Thesis Topic</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['Role'], [ROLE_DEPT_HEAD, ROLE_ADMIN])): ?>
                    <li class="list-group-item"><a href="<?= BASE_URL ?>giangvien/assign">Assign Student to Advisor</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
