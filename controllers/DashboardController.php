<?php
class DashboardController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        // Make sure user is logged in
        checkLogin();
    }

    public function index() {
        $user = $_SESSION['user'];
        $role = $user['Role'];
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $data = [];
        $totalItems = 0;
        
        switch($role) {
            case ROLE_STUDENT:
                // Get student's advisor information
                require_once 'models/SinhVienGiangVienHuongDan.php';
                require_once 'models/DeTai.php';
                
                $svgvModel = new SinhVienGiangVienHuongDan($this->pdo);
                $deTaiModel = new DeTai($this->pdo);
                
                $advisor = $svgvModel->getAdvisorForStudent($user['SinhVienID']);
                $theses = $deTaiModel->getByStudent($user['SinhVienID']);
                
                $data = [
                    'advisor' => $advisor,
                    'theses' => $theses
                ];
                break;
                
            case ROLE_LECTURER:
                // Get lecturer's students and all thesis topics (including pending)
                require_once 'models/GiangVien.php';
                require_once 'models/DeTai.php';
                
                $giangVienModel = new GiangVien($this->pdo);
                $deTaiModel = new DeTai($this->pdo);
                
                $students = $giangVienModel->getStudentsAdvised($user['GiangVienID'], $page, $limit);
                $totalItems = $giangVienModel->countStudentsAdvised($user['GiangVienID']);
                
                // Get both assigned theses and those from assigned students
                $assignedTheses = $deTaiModel->getByLecturer($user['GiangVienID']);
                $studentTheses = $deTaiModel->getFromAssignedStudents($user['GiangVienID']);
                
                // Count pending theses from students
                $pendingTheses = array_filter($studentTheses, function($thesis) {
                    return $thesis['TrangThai'] === 'Pending';
                });
                
                $data = [
                    'students' => $students,
                    'assignedTheses' => $assignedTheses,
                    'studentTheses' => $studentTheses,
                    'pendingCount' => count($pendingTheses),
                    'totalStudents' => $totalItems
                ];
                break;
                
            case ROLE_DEPT_HEAD:
                // Get department stats and pending thesis topics
                require_once 'models/SinhVien.php';
                require_once 'models/GiangVien.php';
                require_once 'models/DeTai.php';
                require_once 'models/SinhVienGiangVienHuongDan.php';
                
                $sinhVienModel = new SinhVien($this->pdo);
                $giangVienModel = new GiangVien($this->pdo);
                $deTaiModel = new DeTai($this->pdo);
                $svgvModel = new SinhVienGiangVienHuongDan($this->pdo);
                
                $pendingTheses = $deTaiModel->getAllWithDetails($page, $limit, 'Pending');
                $totalItems = $deTaiModel->countByStatus('Pending');
                $unassignedStudents = $sinhVienModel->getStudentsWithoutAdvisor();
                $assignmentStats = $svgvModel->countAllAssignments();
                
                $data = [
                    'pendingTheses' => $pendingTheses,
                    'unassignedStudents' => $unassignedStudents,
                    'assignmentStats' => $assignmentStats,
                    'totalPendingTheses' => $totalItems
                ];
                break;
                
            case ROLE_ADMIN:
                // Get overall system stats
                require_once 'models/SinhVien.php';
                require_once 'models/GiangVien.php';
                require_once 'models/User.php';
                require_once 'models/DeTai.php';
                
                $sinhVienModel = new SinhVien($this->pdo);
                $giangVienModel = new GiangVien($this->pdo);
                $userModel = new User($this->pdo);
                $deTaiModel = new DeTai($this->pdo);
                
                $users = $userModel->getPaginatedUsers($page, $limit);
                $totalItems = $userModel->count();
                $studentCount = $sinhVienModel->count();
                $lecturerCount = $giangVienModel->count();
                $approvedTheses = $deTaiModel->countByStatus('Approved');
                $pendingTheses = $deTaiModel->countByStatus('Pending');
                
                $data = [
                    'users' => $users,
                    'studentCount' => $studentCount,
                    'lecturerCount' => $lecturerCount,
                    'approvedTheses' => $approvedTheses,
                    'pendingTheses' => $pendingTheses,
                    'totalUsers' => $totalItems
                ];
                break;
        }
        
        // Calculate pagination
        $totalPages = ceil($totalItems / $limit);
        
        require_once 'views/layouts/header.php';
        require_once 'views/dashboard/index.php';
        require_once 'views/layouts/footer.php';
    }
}
