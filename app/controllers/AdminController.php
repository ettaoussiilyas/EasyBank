<?php
require_once(__DIR__ . '/../models/Statistics.php');
require_once(__DIR__ . '/../models/Accounts.php');
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../validators/UserValidator.php');
require_once(__DIR__ . '/../validators/AccountValidator.php');

class AdminController extends BaseController {
    private $statsModel;
    private $accountsModel;
    private $usersModel;
    private $userValidator;
    private $accountValidator;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        // Vérifier si l'utilisateur est un admin
        $this->usersModel = new User();
        $user = $this->usersModel->getUserById($_SESSION['user_id']);
        if (!$user || $user['role'] !== 'admin') {
            header('Location: /login');
            exit;
        }

        $this->statsModel = new Statistics();
        $this->accountsModel = new Accounts();
        $this->userValidator = new UserValidator();
        $this->accountValidator = new AccountValidator();
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
        if (!$this->accountValidator->validate($_POST)) {
            $_SESSION['errors'] = $this->accountValidator->getErrors();
            $this->accounts();
            exit;
        }
        
        $result = $this->accountsModel->updateAccount(
            $_POST['account_id'],
            $_POST['account_type'],
            $_POST['status']
        );
        
        if ($result) {
            $_SESSION['success'] = "Account updated successfully";
        } else {
            $_SESSION['errors'] = ["Failed to update account"];
        }
        
        $this->accounts();
        exit;
    }

    public function deleteAccount() {
        $account_id = $_POST['account_id'];
        $this->accountsModel->deleteAccount($account_id);
        $_SESSION['success'] = "Account deleted successfully";
        $this->accounts();
    }
    public function toggleStatus() {
        $account_id = $_POST['account_id'];
        $this->accountsModel->toggleStatus($account_id);
        $_SESSION['success'] = "Account status updated successfully";
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
        $users = $this->usersModel->getAllUsers();
        $this->renderAdmin('users', ["users" => $users]);
    }

    public function createUser() {
        if (!$this->userValidator->validate($_POST)) {
            $_SESSION['errors'] = $this->userValidator->getErrors();
            $this->users();
            exit;
        }

        $password = bin2hex(random_bytes(6));
        $userId = $this->usersModel->createUser(
            $_POST['name'],
            $_POST['email'],
            $password,
            $_POST['profile_pic'] ?? null
        );
        
        if ($userId) {
            $accountResult = $this->accountsModel->createAccount($userId, 'courant', 0, 'active');
            
            if ($accountResult) {
                $_SESSION['success'] = "User created successfully. Generated password: " . $password;
            } else {
                $_SESSION['success'] = "User created but failed to create default account. Generated password: " . $password;
            }
        } else {
            $_SESSION['errors'] = ["An error occurred while creating the user"];
        }
        
        $this->users();
        exit;
    }

    public function deleteUser() {
        if (empty($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
            $_SESSION['errors'] = ["Invalid user ID"];
            $this->users();
            exit;
        }

        $result = $this->usersModel->deleteUser($_POST['user_id']);
        
        if ($result) {
            $_SESSION['success'] = "User deleted successfully";
        } else {
            $_SESSION['errors'] = ["Failed to delete user"];
        }
        
        $this->users();
        exit;
    }

    public function updateUser() {
        if (!$this->userValidator->validate($_POST)) {
            $_SESSION['errors'] = $this->userValidator->getErrors();
            $this->users();
            exit;
        }

        $password = null;
        if (isset($_POST['generate_new_password']) && $_POST['generate_new_password'] === 'on') {
            $password = bin2hex(random_bytes(6));
        }

        $result = $this->usersModel->updateUsers(
            $_POST['user_id'],
            $_POST['name'],
            $_POST['email'],
            $password,
            $_POST['profile_pic'] ?? null,
            $_POST['role'] ?? 'user'
        );
        
        if ($result) {
            $success_message = "User updated successfully";
            if ($password) {
                $success_message .= ". New password: " . $password;
            }
            $_SESSION['success'] = $success_message;
        } else {
            $_SESSION['errors'] = ["Failed to update user"];
        }
        
        $this->users();
        exit;
    }

    public function createAccount() {
        if (!$this->accountValidator->validate($_POST)) {
            $_SESSION['errors'] = $this->accountValidator->getErrors();
            $this->users();
            exit;
        }

        $result = $this->accountsModel->createAccount(
            $_POST['user_id'],
            $_POST['account_type'],
            0,
            'active'
        );

        if ($result) {
            $_SESSION['success'] = "Account created successfully";
        } else {
            $_SESSION['errors'] = ["Failed to create account"];
        }

        $this->users();
        exit;
    }

    public function searchUsers() {
        $term = $_GET['term'] ?? '';
        $users = $this->usersModel->searchUsers($term);
        
        header('Content-Type: application/json');
        echo json_encode($users);
        exit;
    }

    public function reports() {
        try {
            $statistics = $this->statsModel->getReports();
            if (!$statistics) {
                $_SESSION['errors'] = ["Failed to load statistics"];
            }
            $this->renderAdmin('reports', [
                'totaldeposit' => $statistics['totaldeposit'],
                'totalwithdrawal' => $statistics['totalwithdrawal'],
                'totalBalance' => $statistics['totalBalance'],
                'monthlyStats' => $statistics['monthlyStats']
            ]);
        } catch (Exception $e) {
            $_SESSION['errors'] = ["An error occurred while loading the reports"];
            $this->renderAdmin('reports', [
                'totaldeposit' => 0,
                'totalwithdrawal' => 0,
                'totalBalance' => 0,
                'monthlyStats' => []
            ]);
        }
    }

}