<?php
class HomeController {
    private $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function index() {
        // Load homepage with statistics
        require_once 'models/SinhVien.php';
        require_once 'models/GiangVien.php';
        require_once 'models/DeTai.php';
        
        $sinhVienModel = new SinhVien($this->pdo);
        $giangVienModel = new GiangVien($this->pdo);
        $deTaiModel = new DeTai($this->pdo);
        
        $totalStudents = $sinhVienModel->count();
        $totalLecturers = $giangVienModel->count();
        $totalTheses = $deTaiModel->count();
        $pendingTheses = $deTaiModel->countByStatus('Pending');
        
        require_once 'views/layouts/header.php';
        require_once 'views/home/index.php';
        require_once 'views/layouts/footer.php';
    }
}
