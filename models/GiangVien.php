<?php
require_once 'BaseModel.php';

class GiangVien extends BaseModel {
    protected $table = 'GiangVien';
    protected $primaryKey = 'GiangVienID';
    
    // Get all lecturers with search and pagination
    public function getAllWithPagination($page = 1, $limit = 10, $search = '') {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM GiangVien";
        
        if (!empty($search)) {
            $sql .= " WHERE HoTen LIKE ? OR MaGiangVien LIKE ? OR Email LIKE ? OR BoMon LIKE ?";
            $params = ["%$search%", "%$search%", "%$search%", "%$search%"];
            
            $stmt = $this->pdo->prepare($sql . " LIMIT $limit OFFSET $offset");
            $stmt->execute($params);
        } else {
            $stmt = $this->pdo->prepare($sql . " LIMIT $limit OFFSET $offset");
            $stmt->execute();
        }
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Count total lecturers with search
    public function countWithSearch($search = '') {
        $sql = "SELECT COUNT(*) FROM GiangVien";
        
        if (!empty($search)) {
            $sql .= " WHERE HoTen LIKE ? OR MaGiangVien LIKE ? OR Email LIKE ? OR BoMon LIKE ?";
            $params = ["%$search%", "%$search%", "%$search%", "%$search%"];
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
        } else {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        }
        
        return $stmt->fetchColumn();
    }
    
    // Get students advised by a lecturer
    public function getStudentsAdvised($giangVienID, $page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->pdo->prepare("
            SELECT sv.* FROM SinhVien sv
            INNER JOIN SinhVienGiangVienHuongDan svgv ON sv.SinhVienID = svgv.SinhVienID
            WHERE svgv.GiangVienID = ?
            LIMIT $limit OFFSET $offset
        ");
        $stmt->execute([$giangVienID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Count students advised by a lecturer
    public function countStudentsAdvised($giangVienID) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) FROM SinhVienGiangVienHuongDan
            WHERE GiangVienID = ?
        ");
        $stmt->execute([$giangVienID]);
        return $stmt->fetchColumn();
    }
}
