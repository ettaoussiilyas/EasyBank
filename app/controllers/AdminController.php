<?php
require_once(__DIR__ . '/../models/Statistics.php');
require_once(__DIR__ . '/../models/Accounts.php');



class AdminController extends BaseController {
    private $statsModel;
    private $accountsModel;
    private $userModel;

    public function __construct() {
        $this->statsModel = new Statistics();
        $this->accountsModel = new Accounts();
        $this->userModel = new User();
    }

    public function index() {
        $statistics = $this->statsModel->getStatistics();
        $this->renderAdmin('index', [
            'totalClients' => $statistics['totalClients'],
            'activeAccounts' => $statistics['activeAccounts'],
            'totalTransactions' => $statistics['totalTransactions'],
            'totalBalance' => $statistics['totalBalance'],
            'latestTransactions' => $statistics['latestTransactions'],
            'newAccounts' => $statistics['newAccounts']
        ]);
    }

    public function accounts() {
        $accounts = $this->accountsModel->getAllAccounts();
        $this->renderAdmin('accounts', ["accounts" => $accounts]);
    }

    public function updateAccount() {
        $errors = [];
        
        if (empty($_POST['account_id']) || !is_numeric($_POST['account_id'])) {
            $errors[] = "Invalid account ID";
        }
        
        if (empty($_POST['account_type']) || !in_array($_POST['account_type'], ['courant', 'epargne'])) {
            $errors[] = "Invalid account type";
        }
        
        if (!isset($_POST['balance']) || !is_numeric($_POST['balance']) || $_POST['balance'] < 0) {
            $errors[] = "Invalid balance amount";
        }
        
        if (empty($_POST['status']) || !in_array($_POST['status'], ['active', 'inactive'])) {
            $errors[] = "Invalid status";
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->accounts();
            exit;
        }
        
        $this->accountsModel->updateAccount(
            $_POST['account_id'],
            $_POST['account_type'],
            $_POST['balance'],
            $_POST['status']
        );
        
        $this->accounts();
    }

    public function deleteAccount() {
        $account_id = $_POST['account_id'];
        $this->accountsModel->deleteAccount($account_id);
        $this->accounts();
    }
    public function toggleStatus() {
        $account_id = $_POST['account_id'];
        $this->accountsModel->toggleStatus($account_id);
        $this->accounts();
    }
    public function searchAccounts() {
        $term = $_GET['term'] ?? '';
        $status = $_GET['status'] ?? '';
        $accounts = $this->accountsModel->searchAccounts($term);
        
      
        if ($status) {
            $accounts = array_filter($accounts, function($account) use ($status) {
                return $account['status'] === $status;
            });
        }
        
        header('Content-Type: application/json');
        echo json_encode(array_values($accounts));
        exit;
    }

    public function users() {
        $users = $this->userModel->getAllUsers();
        $this->renderAdmin('users', ["users" => $users]); 
    }

}
