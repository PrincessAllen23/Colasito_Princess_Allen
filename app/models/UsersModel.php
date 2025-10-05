<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class UsersModel extends Model {
    protected $table = 'students';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all users
     * Signature updated to match parent: all($with_deleted = false)
     */
    public function all($with_deleted = false)
    {
        // If your framework supports soft-deletes, you can use $with_deleted to include them.
        return $this->db->table($this->table)->get_all();
    }

    /**
     * Find user by ID (matches parent signature)
     */
    public function find($id, $with_deleted = false)
    {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->get();
    }

    /**
     * Insert new user
     */
    public function insert($data)
    {
        return $this->db->table($this->table)->insert($data);
    }

    /**
     * Update user by ID
     * Added $with_deleted optional param to stay compatible with parent signatures.
     */
    public function update($id, $data, $with_deleted = false)
    {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->update($data);
    }

    /**
     * Delete user by ID
     * Added $purge optional param to stay compatible with parent signatures.
     */
    public function delete($id, $purge = false)
    {
        return $this->db->table($this->table)
                        ->where($this->primary_key, $id)
                        ->delete();
    }

    /**
     * Check if given columns exist in the table
     *
     * @param array $cols
     * @return bool
     */
    public function has_columns(array $cols)
    {
        try {
            $rows = $this->db->raw("SHOW COLUMNS FROM {$this->table}")->fetchAll(PDO::FETCH_ASSOC);
            $existing = array_map(function($r){ return $r['Field']; }, $rows);
            foreach ($cols as $c) {
                if (!in_array($c, $existing)) return false;
            }
            return true;
        } catch (Exception $e) {
            // If SHOW COLUMNS fails (permission or other), return false so caller can handle
            return false;
        }
    }
    
}
