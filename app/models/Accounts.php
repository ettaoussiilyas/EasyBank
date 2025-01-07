<?php
require_once(__DIR__ . '/../config/db.php');
class Accounts extends Db {
    
    public function __construct() {
        parent::__construct();
    }

    // Récupérer tous les comptes
    public function getAllAccounts() {
        try {
            $stmt = $this->conn->query("
                SELECT 
                    accounts.*,
                    users.name as client_name,
                    users.email
                FROM accounts 
                JOIN users ON accounts.user_id = users.id
                ORDER BY accounts.created_at DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
} 