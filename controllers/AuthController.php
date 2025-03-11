<?php
require_once 'models/User.php';

class AuthController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login() {
        // Redirect if already logged in
        if (isset($_SESSION['user'])) {
            redirect('home/index');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = new User($this->pdo);
            $user = $userModel->login($username, $password);

            if ($user) {
                $_SESSION['user'] = $user;
                
                // Load additional data based on role
                if ($user['Role'] === ROLE_STUDENT && $user['SinhVienID']) {
                    require_once 'models/SinhVien.php';
                    $sinhVienModel = new SinhVien($this->pdo);
                    $sinhVien = $sinhVienModel->find($user['SinhVienID']);
                    $_SESSION['profile'] = $sinhVien;
                } else if (($user['Role'] === ROLE_LECTURER || $user['Role'] === ROLE_DEPT_HEAD) && $user['GiangVienID']) {
                    require_once 'models/GiangVien.php';
                    $giangVienModel = new GiangVien($this->pdo);
                    $giangVien = $giangVienModel->find($user['GiangVienID']);
                    $_SESSION['profile'] = $giangVien;
                }
                
                redirect('dashboard/index');
            } else {
                $error = "Invalid credentials.";
            }
        }

        require_once 'views/layouts/simple_header.php';
        require_once 'views/auth/login.php';
        require_once 'views/layouts/simple_footer.php';
    }

    public function logout() {
        session_destroy();
        redirect('auth/login');
    }

    public function register() {
        // Optional: If student registration is allowed
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            require_once 'models/SinhVien.php';
            require_once 'models/User.php';
            
            // Create student first
            $sinhVienModel = new SinhVien($this->pdo);
            $studentData = [
                'HoTen' => $_POST['HoTen'],
                'MaSinhVien' => $_POST['MaSinhVien'],
                'NgaySinh' => $_POST['NgaySinh'],
                'Lop' => $_POST['Lop'],
                'Email' => $_POST['Email'],
                'SoDienThoai' => $_POST['SoDienThoai']
            ];
            
            $sinhVienID = $sinhVienModel->create($studentData);
            
            // Then create user account
            $userModel = new User($this->pdo);
            $userData = [
                'Username' => $_POST['Username'],
                'Password' => password_hash($_POST['Password'], PASSWORD_DEFAULT),
                'Role' => ROLE_STUDENT,
                'SinhVienID' => $sinhVienID
            ];
            
            $userModel->create($userData);
            
            redirect('auth/login');
        }
        
        require_once 'views/layouts/simple_header.php';
        require_once 'views/auth/register.php';
        require_once 'views/layouts/simple_footer.php';
    }
}
?>
