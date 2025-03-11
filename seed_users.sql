START TRANSACTION;

-- Insert a sample student
INSERT INTO SinhVien (HoTen, MaSinhVien, NgaySinh, Lop, Email, SoDienThoai)
VALUES ('Nguyen Van A', 'SV001', '2000-01-01', 'CNTT1', 'sv1@example.com', '0123456789');
SET @sinhVienID = LAST_INSERT_ID();

-- Insert a sample lecturer
INSERT INTO GiangVien (HoTen, MaGiangVien, Email, SoDienThoai, BoMon)
VALUES ('Tran Thi B', 'GV001', 'gv1@example.com', '0987654321', 'Computer Science');
SET @giangVienID = LAST_INSERT_ID();

-- Precomputed hashed password for 'bintheky22'
SET @passwordHash = '$2y$10$xZodRwOaheCrDVykhHGhuOTEQplxTHyk9pO0Et9Dd2KelmCfASbcy';

-- Insert user for Student role with link to SinhVien
INSERT INTO NguoiDung (Username, Password, Role, SinhVienID)
VALUES ('student1', @passwordHash, 'Student', @sinhVienID);

-- Insert user for Lecturer role with link to GiangVien
INSERT INTO NguoiDung (Username, Password, Role, GiangVienID)
VALUES ('lecturer1', @passwordHash, 'Lecturer', @giangVienID);

-- Insert user for DepartmentHead role (no foreign key)
INSERT INTO NguoiDung (Username, Password, Role)
VALUES ('depthead1', @passwordHash, 'DepartmentHead');

-- Insert user for Administrator role (no foreign key)
INSERT INTO NguoiDung (Username, Password, Role)
VALUES ('admin1', @passwordHash, 'Administrator');

COMMIT;
