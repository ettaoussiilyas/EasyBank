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
                    users.profile_pic,
                    accounts.status
                FROM accounts 
                JOIN users ON accounts.user_id = users.id
                WHERE users.id != 1
                ORDER BY accounts.created_at DESC
            ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAccount($id, $account_type, $balance, $status)
    {
        $sql = "UPDATE accounts 
                SET 
                    account_type = ?,
                    balance = ?,
                    status = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        $params = [
            $account_type,
            $balance,
            $status,
            $id
        ];

        return $stmt->execute($params);
    }
    public function deleteAccount($id)
    {
        $sql = "DELETE FROM accounts WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $params = [$id];
        return $stmt->execute($params);
    }
    public function toggleStatus($id)
    {
        $sql = "UPDATE accounts 
                SET status = CASE 
                    WHEN status = 'active' THEN 'inactive' 
                    ELSE 'active' 
                END 
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
