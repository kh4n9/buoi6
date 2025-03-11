<?php
class DeTaiController {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
        // All authenticated users can access thesis controller but methods will check specific permissions
        checkLogin();
    }
    
    public function index() {
        require_once 'models/DeTai.php';
        
        $user = $_SESSION['user'];
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $limit = 10;
        
        $deTaiModel = new DeTai($this->pdo);
        
        // Different users see different thesis lists
        if ($user['Role'] === ROLE_STUDENT) {
            $theses = $deTaiModel->getByStudent($user['SinhVienID']);
            $totalTheses = count($theses); // Simple count for student's own theses
        } else if ($user['Role'] === ROLE_LECTURER) {
            // Lecturers see both their assigned theses and theses from students they advise
            $theses = $deTaiModel->getFromAssignedStudents($user['GiangVienID']);
            $totalTheses = count($theses);
        } else {
            // Department heads and admins see all theses with optional filtering
            $theses = $deTaiModel->getAllWithDetails($page, $limit, $status);
            $totalTheses = $deTaiModel->countByStatus($status);
        }
        
        $totalPages = ceil($totalTheses / $limit);
        
        require_once 'views/layouts/header.php';
        require_once 'views/detai/index.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function create() {
        // Only students can create thesis topics
        if ($_SESSION['user']['Role'] !== ROLE_STUDENT) {
            die("Only students can create thesis topics");
        }
        
        require_once 'views/layouts/header.php';
        require_once 'views/detai/create.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/DeTai.php';
            
            // Make sure this is a student
            if ($_SESSION['user']['Role'] !== ROLE_STUDENT) {
                die("Only students can create thesis topics");
            }
            
            $data = [
                'SinhVienID' => $_SESSION['user']['SinhVienID'],
                'TenDeTai' => $_POST['TenDeTai'],
                'MoTa' => $_POST['MoTa'],
                'TrangThai' => 'Pending',
                'NgayNop' => date('Y-m-d')
            ];
            
            $deTaiModel = new DeTai($this->pdo);
            $deTaiModel->create($data);
            
            redirect('detai/index');
        }
    }
    
    public function view($id) {
        require_once 'models/DeTai.php';
        
        $deTaiModel = new DeTai($this->pdo);
        $thesis = $deTaiModel->find($id);
        
        if (!$thesis) {
            die("Thesis not found");
        }
        
        // Get more details about the thesis
        require_once 'models/SinhVien.php';
        require_once 'models/GiangVien.php';
        
        $sinhVienModel = new SinhVien($this->pdo);
        $giangVienModel = new GiangVien($this->pdo);
        
        $student = $sinhVienModel->find($thesis['SinhVienID']);
        $advisor = null;
        
        if ($thesis['GiangVienID']) {
            $advisor = $giangVienModel->find($thesis['GiangVienID']);
        }
        
        require_once 'views/layouts/header.php';
        require_once 'views/detai/view.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function approve($id) {
        // Only department heads can approve
        if ($_SESSION['user']['Role'] !== ROLE_DEPT_HEAD) {
            die("Only department heads can approve thesis topics");
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/DeTai.php';
            
            $giangVienID = $_POST['giangVienID'];
            
            $deTaiModel = new DeTai($this->pdo);
            $deTaiModel->approve($id, $giangVienID);
            
            redirect('detai/index');
        }
        
        // Get the thesis and available lecturers
        require_once 'models/DeTai.php';
        require_once 'models/GiangVien.php';
        
        $deTaiModel = new DeTai($this->pdo);
        $giangVienModel = new GiangVien($this->pdo);
        
        $thesis = $deTaiModel->find($id);
        $lecturers = $giangVienModel->getAll();
        
        require_once 'views/layouts/header.php';
        require_once 'views/detai/approve.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function reject($id) {
        // Only department heads can reject
        if ($_SESSION['user']['Role'] !== ROLE_DEPT_HEAD) {
            die("Only department heads can reject thesis topics");
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/DeTai.php';
            
            $ghiChu = $_POST['ghiChu'];
            
            $deTaiModel = new DeTai($this->pdo);
            $deTaiModel->reject($id, $ghiChu);
            
            redirect('detai/index');
        }
        
        // Get the thesis
        require_once 'models/DeTai.php';
        
        $deTaiModel = new DeTai($this->pdo);
        $thesis = $deTaiModel->find($id);
        
        require_once 'views/layouts/header.php';
        require_once 'views/detai/reject.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function edit($id) {
        require_once 'models/DeTai.php';
        
        $deTaiModel = new DeTai($this->pdo);
        $thesis = $deTaiModel->find($id);
        
        if (!$thesis) {
            die("Thesis not found");
        }
        
        // Check permissions: only admins, department heads, or assigned lecturers can edit
        $user = $_SESSION['user'];
        $canEdit = false;
        
        if (in_array($user['Role'], [ROLE_ADMIN, ROLE_DEPT_HEAD])) {
            $canEdit = true;
        } elseif ($user['Role'] === ROLE_LECTURER && 
                 ($deTaiModel->isLecturerAssigned($id, $user['GiangVienID']) || 
                  $deTaiModel->isLecturerAdvisor($id, $user['GiangVienID']))) {
            $canEdit = true;
        }
        
        if (!$canEdit) {
            die("You don't have permission to edit this thesis topic");
        }
        
        require_once 'views/layouts/header.php';
        require_once 'views/detai/edit.php';
        require_once 'views/layouts/footer.php';
    }
    
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('detai/index');
        }
        
        require_once 'models/DeTai.php';
        
        $deTaiModel = new DeTai($this->pdo);
        $thesis = $deTaiModel->find($id);
        
        if (!$thesis) {
            die("Thesis not found");
        }
        
        // Check permissions: only admins, department heads, or assigned lecturers can update
        $user = $_SESSION['user'];
        $canEdit = false;
        
        if (in_array($user['Role'], [ROLE_ADMIN, ROLE_DEPT_HEAD])) {
            $canEdit = true;
        } elseif ($user['Role'] === ROLE_LECTURER && 
                 ($deTaiModel->isLecturerAssigned($id, $user['GiangVienID']) || 
                  $deTaiModel->isLecturerAdvisor($id, $user['GiangVienID']))) {
            $canEdit = true;
        }
        
        if (!$canEdit) {
            die("You don't have permission to update this thesis topic");
        }
        
        $data = [
            'TenDeTai' => $_POST['TenDeTai'],
            'MoTa' => $_POST['MoTa']
        ];
        
        // Only admins and department heads can change status
        if (in_array($user['Role'], [ROLE_ADMIN, ROLE_DEPT_HEAD]) && isset($_POST['TrangThai'])) {
            $data['TrangThai'] = $_POST['TrangThai'];
            
            if ($_POST['TrangThai'] !== $thesis['TrangThai']) {
                $data['NgayDuyet'] = date('Y-m-d');
            }
        }
        
        // Admin can reassign to different lecturer
        if ($user['Role'] === ROLE_ADMIN && isset($_POST['GiangVienID'])) {
            $data['GiangVienID'] = $_POST['GiangVienID'] ?: null;
        }
        
        $deTaiModel->updateDetails($id, $data);
        redirect('detai/view/' . $id);
    }
    
    public function changeStatus($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('detai/view/' . $id);
        }
        
        require_once 'models/DeTai.php';
        
        $deTaiModel = new DeTai($this->pdo);
        $thesis = $deTaiModel->find($id);
        
        if (!$thesis) {
            die("Thesis not found");
        }
        
        // Only admins, department heads, or assigned lecturers can change status
        $user = $_SESSION['user'];
        $canChangeStatus = false;
        
        if (in_array($user['Role'], [ROLE_ADMIN, ROLE_DEPT_HEAD])) {
            $canChangeStatus = true;
        } elseif ($user['Role'] === ROLE_LECTURER && 
                 ($deTaiModel->isLecturerAssigned($id, $user['GiangVienID']) || 
                  $deTaiModel->isLecturerAdvisor($id, $user['GiangVienID']))) {
            $canChangeStatus = true;
        }
        
        if (!$canChangeStatus) {
            die("You don't have permission to change the status of this thesis topic");
        }
        
        $status = $_POST['status'];
        $ghiChu = isset($_POST['ghiChu']) ? $_POST['ghiChu'] : null;
        
        $deTaiModel->updateStatus($id, $status, $ghiChu);
        redirect('detai/view/' . $id);
    }
}
