<?php

abstract class BaseModel
{
    protected $db;
    protected $table;

    public function __construct()
    {
        $this->db = $this->getConnection();
    }    /**
     * Get database connection
     */
    private function getConnection()
    {
        require_once __DIR__ . '/../config/database.php';
        return DatabaseConfig::getConnection();
    }

    /**
     * Find record by ID
     */
    public function find($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get all records
     */
    public function all()
    {
        $stmt = $this->db->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Create new record
     */
    public function create($data)
    {
        $columns = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})");
        return $stmt->execute($data);
    }

    /**
     * Update record by ID
     */
    public function update($id, $data)
    {
        $setClause = implode(' = ?, ', array_keys($data)) . ' = ?';
        $values = array_values($data);
        $values[] = $id;
        
        $stmt = $this->db->prepare("UPDATE {$this->table} SET {$setClause} WHERE id = ?");
        return $stmt->execute($values);
    }

    /**
     * Delete record by ID
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Find records with conditions
     */
    public function where($conditions = [])
    {
        $whereClause = '';
        $values = [];

        if (!empty($conditions)) {
            $whereClause = 'WHERE ' . implode(' = ? AND ', array_keys($conditions)) . ' = ?';
            $values = array_values($conditions);
        }

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} {$whereClause}");
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
