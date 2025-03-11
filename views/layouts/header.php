<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITE_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        
        main {
            padding-top: 20px;
        }
        
        .navbar-brand {
            padding-top: .75rem;
            padding-bottom: .75rem;
            font-size: 1rem;
            background-color: rgba(0, 0, 0, .25);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }
    </style>
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="<?= BASE_URL ?>home/index"><?= SITE_NAME ?></a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="w-100"></div>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <span class="nav-link px-3 text-light"><?= $_SESSION['user']['Username'] ?> (<?= $_SESSION['user']['Role'] ?>)</span>
            </div>
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="<?= BASE_URL ?>auth/logout">Sign out</a>
            </div>
        </div>
    </header>
    
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>dashboard/index">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        
                        <?php if ($_SESSION['user']['Role'] === ROLE_STUDENT): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>detai/index">
                                    <i class="bi bi-file-text"></i> My Thesis Topics
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>detai/create">
                                    <i class="bi bi-file-earmark-plus"></i> Submit New Topic
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ($_SESSION['user']['Role'] === ROLE_LECTURER): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>detai/index">
                                    <i class="bi bi-file-text"></i> Assigned Theses
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if (in_array($_SESSION['user']['Role'], [ROLE_DEPT_HEAD, ROLE_ADMIN])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>sinhvien/index">
                                    <i class="bi bi-people"></i> Manage Students
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>giangvien/index">
                                    <i class="bi bi-person-workspace"></i> Manage Lecturers
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>giangvien/assign">
                                    <i class="bi bi-link"></i> Assign Advisors
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>giangvien/assignments">
                                    <i class="bi bi-list-check"></i> View Assignments
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= BASE_URL ?>detai/index">
                                    <i class="bi bi-journals"></i> Thesis Topics
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ($_SESSION['user']['Role'] === ROLE_ADMIN): ?>
                            <li class="nav-item mt-4">
                                <div class="nav-link">
                                    <i class="bi bi-gear-fill"></i> Admin Tools
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="#">
                                    <i class="bi bi-person-plus"></i> User Management
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link ms-3" href="#">
                                    <i class="bi bi-bar-chart"></i> Statistics
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
