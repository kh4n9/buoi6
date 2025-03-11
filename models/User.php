<?php
require_once 'BaseModel.php';

class User extends BaseModel {
    protected $table = 'NguoiDung';
    protected $primaryKey = 'UserID';
    
    public function login($username, $password) {
         $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Username = ?");
         $stmt->execute([$username]);
         $user = $stmt->fetch(PDO::FETCH_ASSOC);
         
         if($user && password_verify($password, $user['Password'])) {
             return $user;
         }
         return false;
    }
    
    // Get user by role
    public function findByRole($role) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Role = ?");
        $stmt->execute([$role]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Register new user
    public function register($userData) {
        // Hash the password
        $userData['Password'] = password_hash($userData['Password'], PASSWORD_DEFAULT);
        return $this->create($userData);
    }
    
    // Check if username exists
    public function usernameExists($username) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM {$this->table} WHERE Username = ?");
        $stmt->execute([$username]);
        return $stmt->fetchColumn() > 0;
    }
    
    // Get users with pagination
    public function getPaginatedUsers($page = 1, $limit = 10) {
        return $this->getAll($page, $limit);
    }
}
