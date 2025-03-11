<?php
require_once 'BaseModel.php';

class SinhVienGiangVienHuongDan extends BaseModel {
    protected $table = 'SinhVienGiangVienHuongDan';
    protected $primaryKey = 'ID';
    
    // Assign student to advisor
    public function assignStudentToAdvisor($sinhVienID, $giangVienID, $ghiChu = null) {
        $data = [
            'SinhVienID' => $sinhVienID,
            'GiangVienID' => $giangVienID,
            'NgayBatDau' => date('Y-m-d'),
            'GhiChu' => $ghiChu
        ];
        return $this->create($data);
    }
    
    // Check if student is already assigned
    public function isStudentAssigned($sinhVienID) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table} WHERE SinhVienID = ?");
        $stmt->execute([$sinhVienID]);
        return $stmt->fetchColumn() > 0;
    }
    
    // Get advisor for student
    public function getAdvisorForStudent($sinhVienID) {
        $stmt = $this->pdo->prepare("
            SELECT gv.*, svgv.NgayBatDau, svgv.GhiChu
            FROM GiangVien gv
            INNER JOIN SinhVienGiangVienHuongDan svgv ON gv.GiangVienID = svgv.GiangVienID
            WHERE svgv.SinhVienID = ?
        ");
        $stmt->execute([$sinhVienID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Get all assignments with details
    public function getAllWithDetails($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("
            SELECT svgv.*, sv.HoTen as TenSinhVien, sv.MaSinhVien, gv.HoTen as TenGiangVien, gv.MaGiangVien
            FROM SinhVienGiangVienHuongDan svgv
            INNER JOIN SinhVien sv ON svgv.SinhVienID = sv.SinhVienID
            INNER JOIN GiangVien gv ON svgv.GiangVienID = gv.GiangVienID
            LIMIT $limit OFFSET $offset
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Count total assignments
    public function countAllAssignments() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table}");
        return $stmt->fetchColumn();
    }
}
