<?php
class SinhVienController {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        // Make sure user is logged in
        checkLogin();
        
        // Check permissions for specific actions
        $action = isset($_GET['url']) ? explode('/', $_GET['url'])[1] ?? '' : '';
        
        // Allow view action for all logged-in users (including lecturers)
        if ($action !== 'view') {
            // Only allow access to Admin or DepartmentHead for other actions
            if (!in_array($_SESSION['user']['Role'], ['Administrator', 'DepartmentHead'])) {
                die("You don't have permission to access this page");
            }
        }
    }
    
    public function index() {
        require_once 'models/SinhVien.php';
        
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $limit = 10;
        
        $sinhVienModel = new SinhVien($this->pdo);
        $sinhviens = $sinhVienModel->getAllWithPagination($page, $limit, $search);
        $totalStudents = $sinhVienModel->countWithSearch($search);
        $totalPages = ceil($totalStudents / $limit);
        
        require_once 'views/layouts/header.php';
        require_once 'views/sinhvien/index.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function create() {
        require_once 'views/layouts/header.php';
        require_once 'views/sinhvien/create.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/SinhVien.php';
            
            $data = [
                'HoTen' => $_POST['HoTen'],
                'MaSinhVien' => $_POST['MaSinhVien'],
                'NgaySinh' => $_POST['NgaySinh'],
                'Lop' => $_POST['Lop'],
                'Email' => $_POST['Email'],
                'SoDienThoai' => $_POST['SoDienThoai']
            ];
            
            $sinhVienModel = new SinhVien($this->pdo);
            $sinhVienId = $sinhVienModel->create($data);
            
            // If user credentials should be created at the same time
            if (isset($_POST['createAccount']) && $_POST['createAccount'] == 1) {
                require_once 'models/User.php';
                
                $username = !empty($_POST['Username']) ? $_POST['Username'] : $_POST['MaSinhVien'];
                $password = !empty($_POST['Password']) ? $_POST['Password'] : $_POST['MaSinhVien'];
                
                $userData = [
                    'Username' => $username,
                    'Password' => password_hash($password, PASSWORD_DEFAULT),
                    'Role' => 'Student',
                    'SinhVienID' => $sinhVienId
                ];
                
                $userModel = new User($this->pdo);
                $userModel->create($userData);
            }
            
            header("Location: " . BASE_URL . "sinhvien/index");
            exit;
        }
    }
    
    public function edit($id) {
        require_once 'models/SinhVien.php';
        
        $sinhVienModel = new SinhVien($this->pdo);
        $sinhVien = $sinhVienModel->find($id);
        
        if (!$sinhVien) {
            die("Student not found");
        }
        
        require_once 'views/layouts/header.php';
        require_once 'views/sinhvien/edit.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/SinhVien.php';
            
            $data = [
                'HoTen' => $_POST['HoTen'],
                'MaSinhVien' => $_POST['MaSinhVien'],
                'NgaySinh' => $_POST['NgaySinh'],
                'Lop' => $_POST['Lop'],
                'Email' => $_POST['Email'],
                'SoDienThoai' => $_POST['SoDienThoai']
            ];
            
            $sinhVienModel = new SinhVien($this->pdo);
            $sinhVienModel->update($id, $data);
            
            header("Location: " . BASE_URL . "sinhvien/index");
            exit;
        }
    }
    
    public function delete($id) {
        require_once 'models/SinhVien.php';
        
        $sinhVienModel = new SinhVien($this->pdo);
        $sinhVienModel->delete($id);
        
        header("Location: " . BASE_URL . "sinhvien/index");
        exit;
    }
    
    public function view($id) {
        require_once 'models/SinhVien.php';
        require_once 'models/SinhVienGiangVienHuongDan.php';
        require_once 'models/DeTai.php';
        
        $sinhVienModel = new SinhVien($this->pdo);
        $svgvModel = new SinhVienGiangVienHuongDan($this->pdo);
        $deTaiModel = new DeTai($this->pdo);
        
        $sinhVien = $sinhVienModel->find($id);
        $advisor = $svgvModel->getAdvisorForStudent($id);
        $theses = $deTaiModel->getByStudent($id);
        
        require_once 'views/layouts/header.php';
        require_once 'views/sinhvien/view.php';
        require_once 'views/layouts/footer.php';
    }
}
