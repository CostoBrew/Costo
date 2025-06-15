<?php

/**
 * Coffee Model
 * Handles coffee-related database operations
 */

require_once __DIR__ . '/BaseModel.php';

class Coffee extends BaseModel
{
    protected $table = 'coffees';

    /**
     * Get all available coffees
     */
    public function getAvailable()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE is_available = 1 ORDER BY name");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Coffee model error: ' . $e->getMessage());
            throw new Exception('Unable to fetch coffees');
        }
    }

    /**
     * Get coffee by ID
     */
    public function getById($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ? AND is_available = 1");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Coffee model error: ' . $e->getMessage());
            throw new Exception('Unable to fetch coffee');
        }
    }

    /**
     * Get featured coffees
     */
    public function getFeatured()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE is_featured = 1 AND is_available = 1 ORDER BY name LIMIT 6");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Coffee model error: ' . $e->getMessage());
            throw new Exception('Unable to fetch featured coffees');
        }
    }

    /**
     * Search coffees by name or description
     */
    public function search($query)
    {
        try {
            $searchTerm = '%' . $query . '%';
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE (name LIKE ? OR description LIKE ?) AND is_available = 1 ORDER BY name");
            $stmt->execute([$searchTerm, $searchTerm]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Coffee model error: ' . $e->getMessage());
            throw new Exception('Unable to search coffees');
        }
    }
}
