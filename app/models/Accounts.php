<?php
require_once(__DIR__ . '/../config/db.php');
class Accounts extends Db {
    
    public function __construct() {
        parent::__construct();
    }

    public function getAllAccounts() {
        try {
            $stmt = $this->conn->query("
                SELECT 
                    accounts.*,
                    users.name as client_name,
                    users.email as client_email
                FROM accounts 
                JOIN users ON accounts.user_id = users.id
                WHERE users.id != 1
                ORDER BY accounts.created_at DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return [];
        }
    }
} 