<?php
require_once(__DIR__ . '/../config/db.php');
class Accounts extends Db
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllAccounts()
    {
       
            $stmt = $this->conn->query("
                SELECT 
                    accounts.*,
                    users.name as name,
                    users.email as email,
                    users.password,
                    users.profile_pic
                FROM accounts 
                JOIN users ON accounts.user_id = users.id
                WHERE users.id != 1
                ORDER BY accounts.created_at DESC
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function updateAccount($id, $account_type, $balance, $name, $email)
    {
        
            $sql = "UPDATE accounts a
                    JOIN users u ON a.user_id = u.id
                    SET 
                        a.account_type = ?,
                        a.balance = ?,
                        u.name = ?,
                        u.email = ?";

            $sql .= " WHERE a.id = ?";

            $stmt = $this->conn->prepare($sql);

            $params = [
                $account_type,
                $balance,
                $name,
                $email,
                $id
            ];

            return $stmt->execute($params);
        
    }

    
}
