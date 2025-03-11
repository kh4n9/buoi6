<?php
require_once 'BaseModel.php';

class SinhVien extends BaseModel {
    protected $table = 'SinhVien';
    protected $primaryKey = 'SinhVienID';
    
    // Get student with advisor information
    public function getWithAdvisor($sinhVienID) {
        $stmt = $this->pdo->prepare("
            SELECT sv.*, gv.HoTen as TenGiangVien, gv.Email as EmailGiangVien
            FROM SinhVien sv
            LEFT JOIN SinhVienGiangVienHuongDan svgv ON sv.SinhVienID = svgv.SinhVienID
            LEFT JOIN GiangVien gv ON svgv.GiangVienID = gv.GiangVienID
            WHERE sv.SinhVienID = ?
        ");
        $stmt->execute([$sinhVienID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Get all students with pagination and search
    public function getAllWithPagination($page = 1, $limit = 10, $search = '') {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM SinhVien";
        
        if (!empty($search)) {
            $sql .= " WHERE HoTen LIKE ? OR MaSinhVien LIKE ? OR Email LIKE ?";
            $params = ["%$search%", "%$search%", "%$search%"];
            
            $stmt = $this->pdo->prepare($sql . " LIMIT $limit OFFSET $offset");
            $stmt->execute($params);
        } else {
            $stmt = $this->pdo->prepare($sql . " LIMIT $limit OFFSET $offset");
            $stmt->execute();
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Count total students with search
    public function countWithSearch($search = '') {
        $sql = "SELECT COUNT(*) FROM SinhVien";
        
        if (!empty($search)) {
            $sql .= " WHERE HoTen LIKE ? OR MaSinhVien LIKE ? OR Email LIKE ?";
            $params = ["%$search%", "%$search%", "%$search%"];
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        
        return $stmt->fetchColumn();
    }
    
    // Get students without advisor
    public function getStudentsWithoutAdvisor() {
        $stmt = $this->pdo->prepare("
            SELECT sv.* FROM SinhVien sv
            LEFT JOIN SinhVienGiangVienHuongDan svgv ON sv.SinhVienID = svgv.SinhVienID
            WHERE svgv.SinhVienID IS NULL
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
