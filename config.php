<?php
session_start();
// Database Settings
$host = 'localhost';
$db   = 'ThesisManagementDB';
$user = 'root';
$pass = '';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8";

// Site Settings
define('BASE_URL', 'http://localhost/buoi6/');
define('SITE_NAME', 'Thesis Advisor Management System');

// Roles
define('ROLE_STUDENT', 'Student');
define('ROLE_LECTURER', 'Lecturer');
define('ROLE_DEPT_HEAD', 'DepartmentHead');
define('ROLE_ADMIN', 'Administrator');

// Create PDO Connection
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Helper Functions
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit;
}

function checkLogin() {
    if (!isset($_SESSION['user'])) {
        redirect("auth/login");
    }
}

function checkRole($allowedRoles) {
    checkLogin();
    if (!in_array($_SESSION['user']['Role'], $allowedRoles)) {
        die("You do not have permission to access this page.");
    }
}
