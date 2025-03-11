<?php
class BaseModel {
    protected $pdo;
    protected $table;
    protected $primaryKey;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Get all records with optional pagination
    public function getAll($page = null, $limit = 10) {
        if ($page !== null) {
            $offset = ($page - 1) * $limit;
            $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} LIMIT $limit OFFSET $offset");
        } else {
            $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Count total records
    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM {$this->table}");
        return $stmt->fetchColumn();
    }
    
    // Find record by primary key
    public function find($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Create new record
    public function create($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));
        
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
        $stmt->execute(array_values($data));
        
        return $this->pdo->lastInsertId();
    }
    
    // Update existing record
    public function update($id, $data) {
        $setStatements = [];
        foreach (array_keys($data) as $column) {
            $setStatements[] = "$column = ?";
        }
        $setClause = implode(", ", $setStatements);
        
        $values = array_values($data);
        $values[] = $id;
        
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET $setClause WHERE {$this->primaryKey} = ?");
        return $stmt->execute($values);
    }
    
    // Delete record
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$id]);
    }
}
