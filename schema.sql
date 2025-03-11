-- File: thesis_management_full.sql

-- 1. Tạo database và chuyển sang sử dụng database đó
CREATE DATABASE IF NOT EXISTS ThesisManagementDB;
USE ThesisManagementDB;

-- 2. Tạo bảng SinhVien (Students)
CREATE TABLE IF NOT EXISTS SinhVien (
    SinhVienID INT AUTO_INCREMENT PRIMARY KEY,
    HoTen VARCHAR(100) NOT NULL,
    MaSinhVien VARCHAR(20) NOT NULL UNIQUE,
    NgaySinh DATE NOT NULL,
    Lop VARCHAR(50) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    SoDienThoai VARCHAR(15)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Tạo bảng GiangVien (Lecturers)
CREATE TABLE IF NOT EXISTS GiangVien (
    GiangVienID INT AUTO_INCREMENT PRIMARY KEY,
    HoTen VARCHAR(100) NOT NULL,
    MaGiangVien VARCHAR(20) NOT NULL UNIQUE,
    Email VARCHAR(100) NOT NULL UNIQUE,
    SoDienThoai VARCHAR(15),
    BoMon VARCHAR(100) NOT NULL  -- Bộ môn
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 4. Tạo bảng NguoiDung (User Authentication & Role-based Access Control)
CREATE TABLE IF NOT EXISTS NguoiDung (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL, -- lưu mật khẩu dạng băm (hashed)
    Role ENUM('Student', 'Lecturer', 'DepartmentHead', 'Administrator') NOT NULL,
    SinhVienID INT DEFAULT NULL,  -- Liên kết nếu người dùng là sinh viên
    GiangVienID INT DEFAULT NULL, -- Liên kết nếu người dùng là giảng viên/trưởng bộ môn
    CreatedAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (SinhVienID) REFERENCES SinhVien(SinhVienID) ON DELETE SET NULL,
    FOREIGN KEY (GiangVienID) REFERENCES GiangVien(GiangVienID) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 5. Tạo bảng SinhVienGiangVienHuongDan (Mapping giữa SinhVien và GiangVien)
CREATE TABLE IF NOT EXISTS SinhVienGiangVienHuongDan (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    SinhVienID INT NOT NULL,
    GiangVienID INT NOT NULL,
    -- Loại bỏ DEFAULT cho NgayBatDau vì CURDATE() không được hỗ trợ làm giá trị hằng số
    NgayBatDau DATE NOT NULL,
    GhiChu VARCHAR(255),
    FOREIGN KEY (SinhVienID) REFERENCES SinhVien(SinhVienID) ON DELETE CASCADE,
    FOREIGN KEY (GiangVienID) REFERENCES GiangVien(GiangVienID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 6. Tạo bảng DeTai (Thesis Topics)
CREATE TABLE IF NOT EXISTS DeTai (
    DeTaiID INT AUTO_INCREMENT PRIMARY KEY,
    SinhVienID INT NOT NULL,      -- Sinh viên đăng ký đề tài
    GiangVienID INT DEFAULT NULL, -- Giảng viên được phân công (nếu có)
    TenDeTai VARCHAR(255) NOT NULL,
    MoTa TEXT,                    -- Mô tả chi tiết đề tài
    TrangThai ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    -- Loại bỏ DEFAULT cho NgayNop vì CURDATE() không được hỗ trợ làm giá trị hằng số
    NgayNop DATE NOT NULL,
    NgayDuyet DATE DEFAULT NULL,
    GhiChu VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (SinhVienID) REFERENCES SinhVien(SinhVienID) ON DELETE CASCADE,
    FOREIGN KEY (GiangVienID) REFERENCES GiangVien(GiangVienID) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 7. Tạo bảng LichSuHuongDan (Progress Tracking & Notes)
CREATE TABLE IF NOT EXISTS LichSuHuongDan (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    SinhVienGiangVienHuongDanID INT NOT NULL, -- Liên kết đến bảng mapping
    NgayCapNhat DATETIME DEFAULT CURRENT_TIMESTAMP,
    NoiDung TEXT NOT NULL,                  -- Nội dung ghi chú/chuyển tiến độ
    CreatedBy VARCHAR(50) NOT NULL,           -- Tên người cập nhật (có thể là username)
    FOREIGN KEY (SinhVienGiangVienHuongDanID) REFERENCES SinhVienGiangVienHuongDan(ID) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
