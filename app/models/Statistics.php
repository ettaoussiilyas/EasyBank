<?php
require_once(__DIR__ . '/../config/db.php');

class Statistics extends Db
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getStatistics()
    {
        try {
            return [
                'totalClients' => $this->getTotalClients(),
                'activeAccounts' => $this->getActiveAccounts(),
                'totalTransactions' => $this->getTotalTransactions(),
                'totalBalance' => $this->getTotalBalance(),
                'latestTransactions' => $this->getLatestTransactions(),
                'newAccounts' => $this->getNewAccounts()
            ];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [
                'totalClients' => 0,
                'activeAccounts' => 0,
                'totalTransactions' => 0,
                'totalBalance' => 0,
                'latestTransactions' => [],
                'newAccounts' => []
            ];
        }
    }


    public function getTotalDeposit()
    {
        $stmt = $this->conn->query("SELECT SUM(amount) as total FROM transactions WHERE transaction_type = 'depot'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getTotalWithdrawal()
    {
        $stmt = $this->conn->query("SELECT SUM(amount) as total FROM transactions WHERE transaction_type = 'retrait'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getReports()
    {
        try {
            return [
                'totaldeposit' => $this->getTotalDeposit(),
                'totalwithdrawal' => $this->getTotalWithdrawal(),
                'totalBalance' => $this->getTotalBalance(),
                'monthlyStats' => $this->getMonthlyStats()
            ];
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return [
                'totaldeposit' => 0,
                'totalwithdrawal' => 0,
                'totalBalance' => 0,
                'monthlyStats' => []
            ];
        }
    }

    public function getMonthlyStats()
    {
            $stmt = $this->conn->query("
                SELECT 
                    DATE_FORMAT(created_at, '%Y-%m') as month,
                    SUM(CASE WHEN transaction_type = 'depot' THEN amount ELSE 0 END) as deposits,
                    SUM(CASE WHEN transaction_type = 'retrait' THEN amount ELSE 0 END) as withdrawals
                FROM transactions
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY month DESC
                LIMIT 12
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
       
    }


    


    private function getTotalClients()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM users WHERE role != 'admin'");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    private function getActiveAccounts()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM accounts");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    private function getTotalTransactions()
    {
        $stmt = $this->conn->query("SELECT COUNT(*) as total FROM transactions");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    private function getTotalBalance()
    {
        $stmt = $this->conn->query("SELECT SUM(balance) as total FROM accounts");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }


    private function getLatestTransactions()
    {
        $stmt = $this->conn->query("
            SELECT 
                t.*,
                u.name as client_name,
                DATE_FORMAT(t.created_at, '%d-%m-%y %H:%i') as formatted_date
            FROM transactions t
            JOIN accounts a ON t.account_id = a.id
            JOIN users u ON a.user_id = u.id
            WHERE u.role != 'admin'
            ORDER BY t.created_at DESC
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    private function getNewAccounts()
    {
        $stmt = $this->conn->query("
            SELECT 
                a.*,
                u.name as client_name,
                a.status
            FROM accounts a
            JOIN users u ON a.user_id = u.id
            WHERE u.role != 'admin'
            ORDER BY a.created_at DESC
            LIMIT 5
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
