<?php
require_once(__DIR__ . '/../config/db.php');
class Accounts extends Db {
    
    public function __construct() {
        parent::__construct();
    }

    public function getAllAccounts() {
        
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

    public function updateAccount($id, $account_type, $status) {
        $sql = "UPDATE accounts 
                SET 
                    account_type = ?,
                    status = ?
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        
        $params = [
            $account_type,
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

    public function toggleStatus($id) {
        $sql = "UPDATE accounts 
                SET status = CASE 
                    WHEN status = 'active' THEN 'inactive' 
                    ELSE 'active' 
                END 
                WHERE id = ?";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function searchAccounts($term) {
        $term = "%$term%";
        $sql = "SELECT 
                    accounts.*,
                    users.name as name,
                    users.email as email,
                    users.profile_pic,
                    accounts.status
                FROM accounts 
                JOIN users ON accounts.user_id = users.id
                WHERE users.id != 1
                AND (
                    users.name LIKE ? 
                    OR users.email LIKE ? 
                    OR accounts.account_type LIKE ?
                    OR accounts.status LIKE ?
                    OR CAST(accounts.balance AS CHAR) LIKE ?
                )
                ORDER BY accounts.created_at DESC";
                
        $stmt = $this->conn->prepare($sql);
        $params = [$term, $term, $term, $term, $term];
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function makeWithdrawal($accountId, $amount) {
        try {
            if (!is_numeric($accountId) || !is_numeric($amount)) {
                throw new InvalidArgumentException("Account ID and amount must be numeric values.");
            }

            if ($amount <= 0) {
                throw new InvalidArgumentException("Withdrawal amount must be greater than zero.");
            }

            // Call the stored procedure
            $stmt = $this->conn->prepare("CALL sp_retired_amount(?, ?)");
            $stmt->bindParam(1, $accountId, PDO::PARAM_INT);
            $stmt->bindParam(2, $amount, PDO::PARAM_STR);
        
            // Execute and fetch results
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
            // Check if withdrawal was successful
            if ($result && isset($result['message']) && $result['message'] === 'Withdrawal successful') {
                return [
                    'success' => true,
                    'message' => 'Withdrawal successful',
                    'new_balance' => $result['new_balance']
                ];
            } else {
                throw new Exception("Withdrawal failed");
            }
        
        } catch (PDOException $e) {
            // Handle database-specific errors
            if ($e->getCode() == '45000') {
                // This is our custom error from the stored procedure
                throw new Exception($e->getMessage());
            }
            // Log the error details for debugging
            error_log("Database error in makeWithdrawal: " . $e->getMessage());
            throw new Exception("An error occurred during the withdrawal process.");
        
        } catch (Exception $e) {
            // Log the error details for debugging
            error_log("Error in makeWithdrawal: " . $e->getMessage());
            throw $e;
        }

        // Example usage:
        /*
        try {
            $result = $bankAccount->makeWithdrawal(1, 80.00);
            echo "Withdrawal successful. New balance: " . $result['new_balance'];
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        */
    }

    public function getAccountsById($id) {

        $stmt = $this->conn->prepare("SELECT * FROM accounts WHERE user_id =?");
        // $stmt = $this->conn->prepare("
        //     SELECT 
        //         accounts.*,
        //         users.name as name,
        //         users.email as email,
        //         users.profile_pic
        //     FROM accounts 
        //     JOIN users ON accounts.user_id = users.id
        //     WHERE accounts.user_id = ?
        // ");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}
