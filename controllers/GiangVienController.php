<?php
class GiangVienController {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        // Only admins or department heads can manage lecturers
        checkRole([ROLE_ADMIN, ROLE_DEPT_HEAD]);
    }
    
    public function index() {
        require_once 'models/GiangVien.php';
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $limit = 10;
        
        $giangVienModel = new GiangVien($this->pdo);
        $giangviens = $giangVienModel->getAllWithPagination($page, $limit, $search);
        $totalLecturers = $giangVienModel->countWithSearch($search);
        $totalPages = ceil($totalLecturers / $limit);
        
        require_once 'views/layouts/header.php';
        require_once 'views/giangvien/index.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function create() {
        require_once 'views/layouts/header.php';
        require_once 'views/giangvien/create.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/GiangVien.php';
            
            $data = [
                'HoTen' => $_POST['HoTen'],
                'MaGiangVien' => $_POST['MaGiangVien'],
                'Email' => $_POST['Email'],
                'SoDienThoai' => $_POST['SoDienThoai'],
                'BoMon' => $_POST['BoMon']
            ];
            
            $giangVienModel = new GiangVien($this->pdo);
            $giangVienId = $giangVienModel->create($data);
            
            // Create user account if specified
            if (isset($_POST['createAccount']) && $_POST['createAccount'] == 1) {
                require_once 'models/User.php';
                
                $role = isset($_POST['isHeadOfDepartment']) && $_POST['isHeadOfDepartment'] == 1 
                    ? ROLE_DEPT_HEAD : ROLE_LECTURER;
                
                $username = !empty($_POST['Username']) ? $_POST['Username'] : $_POST['MaGiangVien'];
                $password = !empty($_POST['Password']) ? $_POST['Password'] : $_POST['MaGiangVien'];
                
                $userData = [
                    'Username' => $username,
                    'Password' => password_hash($password, PASSWORD_DEFAULT),
                    'Role' => $role,
                    'GiangVienID' => $giangVienId
                ];
                
                $userModel = new User($this->pdo);
                $userModel->create($userData);
            }
            
            redirect('giangvien/index');
        }
    }
    
    public function edit($id) {
        require_once 'models/GiangVien.php';
        
        $giangVienModel = new GiangVien($this->pdo);
        $giangVien = $giangVienModel->find($id);
        
        if (!$giangVien) {
            die("Lecturer not found");
        }
        
        require_once 'views/layouts/header.php';
        require_once 'views/giangvien/edit.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/GiangVien.php';
            
            $data = [
                'HoTen' => $_POST['HoTen'],
                'MaGiangVien' => $_POST['MaGiangVien'],
                'Email' => $_POST['Email'],
                'SoDienThoai' => $_POST['SoDienThoai'],
                'BoMon' => $_POST['BoMon']
            ];
            
            $giangVienModel = new GiangVien($this->pdo);
            $giangVienModel->update($id, $data);
            
            redirect('giangvien/index');
        }
    }
    
    public function delete($id) {
        require_once 'models/GiangVien.php';
        
        $giangVienModel = new GiangVien($this->pdo);
        $giangVienModel->delete($id);
        
        redirect('giangvien/index');
    }
    
    public function view($id) {
        require_once 'models/GiangVien.php';
        
        $giangVienModel = new GiangVien($this->pdo);
        $giangVien = $giangVienModel->find($id);
        
        // Get students assigned to this lecturer
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        
        $students = $giangVienModel->getStudentsAdvised($id, $page, $limit);
        $totalStudents = $giangVienModel->countStudentsAdvised($id);
        $totalPages = ceil($totalStudents / $limit);
        
        require_once 'views/layouts/header.php';
        require_once 'views/giangvien/view.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function assign() {
        // Assign students to lecturers
        require_once 'models/SinhVien.php';
        require_once 'models/GiangVien.php';
        require_once 'models/SinhVienGiangVienHuongDan.php';
        
        $sinhVienModel = new SinhVien($this->pdo);
        $giangVienModel = new GiangVien($this->pdo);
        $svgvModel = new SinhVienGiangVienHuongDan($this->pdo);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sinhVienID = $_POST['sinhVienID'];
            $giangVienID = $_POST['giangVienID'];
            $ghiChu = $_POST['ghiChu'] ?? null;
            
            if (!$svgvModel->isStudentAssigned($sinhVienID)) {
                $svgvModel->assignStudentToAdvisor($sinhVienID, $giangVienID, $ghiChu);
                redirect('giangvien/assignments');
            } else {
                $error = "Student is already assigned to an advisor.";
            }
        }
        
        // Get unassigned students and all lecturers for the form
        $students = $sinhVienModel->getStudentsWithoutAdvisor();
        $lecturers = $giangVienModel->getAll();
        
        require_once 'views/layouts/header.php';
        require_once 'views/giangvien/assign.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function assignments() {
        // View all student-advisor assignments
        require_once 'models/SinhVienGiangVienHuongDan.php';
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        
        $svgvModel = new SinhVienGiangVienHuongDan($this->pdo);
        $assignments = $svgvModel->getAllWithDetails($page, $limit);
        $totalAssignments = $svgvModel->countAllAssignments();
        $totalPages = ceil($totalAssignments / $limit);
        
        require_once 'views/layouts/header.php';
        require_once 'views/giangvien/assignments.php';
        require_once 'views/layouts/footer.php';
    }
}
