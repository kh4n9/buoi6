<?php
require_once 'BaseModel.php';

class DeTai extends BaseModel {
    protected $table = 'DeTai';
    protected $primaryKey = 'DeTaiID';
    
    // Get all thesis topics with student and lecturer information
    public function getAllWithDetails($page = 1, $limit = 10, $status = null) {
        $offset = ($page - 1) * $limit;
        $sql = "
            SELECT d.*, sv.HoTen as TenSinhVien, sv.MaSinhVien, gv.HoTen as TenGiangVien
            FROM DeTai d
            INNER JOIN SinhVien sv ON d.SinhVienID = sv.SinhVienID
            LEFT JOIN GiangVien gv ON d.GiangVienID = gv.GiangVienID
        ";
        
        $params = [];
        if ($status !== null) {
            $sql .= " WHERE d.TrangThai = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY d.NgayNop DESC LIMIT $limit OFFSET $offset";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Count total thesis topics by status
    public function countByStatus($status = null) {
        $sql = "SELECT COUNT(*) FROM DeTai";
        $params = [];
        
        if ($status !== null) {
            $sql .= " WHERE TrangThai = ?";
            $params[] = $status;
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    }
    
    // Get thesis topics by student
    public function getByStudent($sinhVienID) {
        $stmt = $this->pdo->prepare("
            SELECT d.*, gv.HoTen as TenGiangVien
            FROM DeTai d
            LEFT JOIN GiangVien gv ON d.GiangVienID = gv.GiangVienID
            WHERE d.SinhVienID = ?
            ORDER BY d.NgayNop DESC
        ");
        $stmt->execute([$sinhVienID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get thesis topics by lecturer
    public function getByLecturer($giangVienID) {
        $stmt = $this->pdo->prepare("
            SELECT d.*, sv.HoTen as TenSinhVien, sv.MaSinhVien
            FROM DeTai d
            INNER JOIN SinhVien sv ON d.SinhVienID = sv.SinhVienID
            WHERE d.GiangVienID = ?
            ORDER BY d.NgayNop DESC
        ");
        $stmt->execute([$giangVienID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Get thesis topics from students assigned to a lecturer (including pending topics)
    public function getFromAssignedStudents($giangVienID) {
        $stmt = $this->pdo->prepare("
            SELECT d.*, sv.HoTen as TenSinhVien, sv.MaSinhVien
            FROM DeTai d
            INNER JOIN SinhVien sv ON d.SinhVienID = sv.SinhVienID
            INNER JOIN SinhVienGiangVienHuongDan svgv ON sv.SinhVienID = svgv.SinhVienID
            WHERE svgv.GiangVienID = ?
            ORDER BY d.NgayNop DESC
        ");
        $stmt->execute([$giangVienID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Approve thesis topic
    public function approve($deTaiID, $giangVienID) {
        $stmt = $this->pdo->prepare("
            UPDATE DeTai
            SET TrangThai = 'Approved', GiangVienID = ?, NgayDuyet = CURRENT_DATE()
            WHERE DeTaiID = ?
        ");
        return $stmt->execute([$giangVienID, $deTaiID]);
    }
    
    // Reject thesis topic
    public function reject($deTaiID, $ghiChu) {
        $stmt = $this->pdo->prepare("
            UPDATE DeTai
            SET TrangThai = 'Rejected', NgayDuyet = CURRENT_DATE(), GhiChu = ?
            WHERE DeTaiID = ?
        ");
        return $stmt->execute([$ghiChu, $deTaiID]);
    }
    
    // Update thesis topic details
    public function updateDetails($deTaiID, $data) {
        return $this->update($deTaiID, $data);
    }
    
    // Change thesis status
    public function updateStatus($deTaiID, $status, $ghiChu = null) {
        $data = [
            'TrangThai' => $status,
            'NgayDuyet' => date('Y-m-d')
        ];
        
        if ($ghiChu !== null) {
            $data['GhiChu'] = $ghiChu;
        }
        
        return $this->update($deTaiID, $data);
    }
    
    // Check if lecturer is assigned to thesis
    public function isLecturerAssigned($deTaiID, $giangVienID) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM DeTai WHERE DeTaiID = ? AND GiangVienID = ?");
        $stmt->execute([$deTaiID, $giangVienID]);
        return $stmt->fetchColumn() > 0;
    }
    
    // Check if lecturer is advisor to the student who submitted thesis
    public function isLecturerAdvisor($deTaiID, $giangVienID) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM DeTai d
            JOIN SinhVienGiangVienHuongDan svgv ON d.SinhVienID = svgv.SinhVienID
            WHERE d.DeTaiID = ? AND svgv.GiangVienID = ?
        ");
        $stmt->execute([$deTaiID, $giangVienID]);
        return $stmt->fetchColumn() > 0;
    }
}
