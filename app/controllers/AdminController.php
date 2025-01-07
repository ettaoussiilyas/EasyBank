<?php
require_once(__DIR__ . '/../models/Statistics.php');
require_once(__DIR__ . '/../models/Accounts.php');


class AdminController extends BaseController {
    private $statsModel;
    private $accountsModel;

    public function __construct() {
        $this->statsModel = new Statistics();
        $this->accountsModel = new Accounts();
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
        $account_id = $_POST['account_id'];
        $account_type = $_POST['account_type'];
        $balance = $_POST['balance'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        
        $this->accountsModel->updateAccount(
            $account_id,
            $account_type,
            $balance,
            $name,
            $email
        );
        
        $this->accounts();
    }

    
}
