<?php
require_once(__DIR__ . '/../models/Statistics.php');
require_once(__DIR__ . '/../models/Accounts.php');
require_once(__DIR__ . '/../models/User.php');



class AdminController extends BaseController {
    private $statsModel;
    private $accountsModel;
    private $usersModel;

    public function __construct() {
        $this->statsModel = new Statistics();
        $this->accountsModel = new Accounts();
        $this->usersModel = new User();
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
        
        if (empty($_POST['status']) || !in_array($_POST['status'], ['active', 'inactive'])) {
            $errors[] = "Invalid status";
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
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
        $errors = [];
        
        if (empty($_POST['name'])) {
            $errors[] = "Name is required";
        } else {
            $name = trim($_POST['name']);
            
            if (strlen($name) < 2) {
                $errors[] = "Name must be at least 2 characters long";
            }
            
            
            

            if (!preg_match('/^[a-zA-ZÀ-ÿ\s\'-]+$/', $name)) {
                $errors[] = "Name contains invalid characters";
            }
            
            $_POST['name'] = $name;
        }
        
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address";
        }
        
        if (!empty($_POST['profile_pic']) && !filter_var($_POST['profile_pic'], FILTER_VALIDATE_URL)) {
            $errors[] = "Invalid profile picture URL";
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->users();
            exit;
        }
        
        $result = $this->usersModel->createUser(
            $_POST['name'],
            $_POST['email'],
            $_POST['profile_pic'] ?? null
        );
        
        if ($result['success']) {
            $_SESSION['success'] = "User created successfully. Generated password: " . $result['password'];
        } else {
            $_SESSION['errors'] = ["Failed to create user"];
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
        $errors = [];
        
        if (empty($_POST['user_id']) || !is_numeric($_POST['user_id'])) {
            $errors[] = "Invalid user ID";
        }

        if (empty($_POST['name'])) {
            $errors[] = "Name is required";
        } else {
            $name = trim($_POST['name']);
            if (strlen($name) < 2) {
                $errors[] = "Name must be at least 2 characters long";
            }
            if (!preg_match('/^[a-zA-ZÀ-ÿ\s\'-]+$/', $name)) {
                $errors[] = "Name contains invalid characters";
            }
        }
        
        if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address";
        }
        
        if (!empty($_POST['profile_pic']) && !filter_var($_POST['profile_pic'], FILTER_VALIDATE_URL)) {
            $errors[] = "Invalid profile picture URL";
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
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
            $_POST['profile_pic'] ?? null
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

}
