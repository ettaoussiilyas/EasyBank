<?php

require_once '../app/includes/autoloaderControllers.php';


class AccountController extends BaseController
{

    private $accountModel;
    private $userModel;


    public function __construct()
    {
        $this->accountModel = new Accounts();
        $this->userModel = new User();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        if (!$user || $user['role'] !== 'user') {
            header('Location: /login');
            exit;
        }


    }

    public function withdrawChecker()
    {
        if (!isset($_POST['amount']) || !isset($_POST['id_account'])) {
            header('Location: /user/account');
            return;
        }

        $amount = floatval($_POST['amount']);
        $account_id = $_POST['id_account'];
        $user_id = $_SESSION['user_id'];

        // Get account and verify it belongs to the user
        $account = $this->accountModel->getAccountById($account_id);

        if (!$account || $account['user_id'] != $user_id) {
            header('Location: /user/account');
            return;
        }

        // Check account status
        $status = $this->accountModel->checkAccountStatus($account_id);
        if ($status === 'inactive') {
            $this->renderClient('withdraw', [
                'account' => $account,
                'error' => 'Ce compte est bloqué. Les retraits ne sont pas autorisés.'
            ]);
            return;
        }

        // Validation checks
        if ($amount < 10) {
            $this->renderClient('withdraw', [
                'account' => $account,
                'error' => 'Le montant minimum de retrait est de 10€'
            ]);
            return;
        }

        if ($account['balance'] < $amount) {
            $this->renderClient('withdraw', [
                'account' => $account,
                'error' => 'Solde insuffisant'
            ]);
            return;
        }

        $description = isset($_POST['description']) ? $_POST['description'] : '';

        // Perform withdrawal
        $success = $this->accountModel->withdraw($account_id, $amount, $description, $user_id);

        if ($success) {
            header('Location: /user/account?success=withdrawal');
        } else {
            $this->renderClient('withdraw', [
                'account' => $account,
                'error' => 'Une erreur est survenue lors du retrait'
            ]);
        }
    }

    public function showAccount()
    {
        //get account and get user to show balnce of account ...

        // $user = $this->userModel->getUserById($_SESSION['user_id']);
        // if (!$user || $user['role'] !== 'user') {
        //     header('Location: /login');
        //     exit;
        // }
        $id = $_SESSION['user_id'];
        $accounts = $this->accountModel->getAccountsById($id);
        $user = $this->userModel->getUserById($id);
        $this->renderClient('account', [
            'user' => $user,
            'accounts' => $accounts
        ]);

    }

    public function showWithdraw()
    {
        if (!isset($_GET['id'])) {
            header('Location: /user/account');
            return;
        }

        $account_id = $_GET['id'];
        $user_id = $_SESSION['user_id'];

        // Get account and verify it belongs to the user
        $account = $this->accountModel->getAccountById($account_id);

        if (!$account || $account['user_id'] != $user_id) {
            header('Location: /user/account');
            return;
        }

        $this->renderClient('withdraw', [
            'account' => $account,
            'error' => isset($_GET['error']) ? $_GET['error'] : null
        ]);
    }

    public function showDeposit()
    {
        $user_id = $_SESSION['user_id'];
        $accounts = $this->accountModel->getAccountsById($user_id);
        
        $this->renderClient('deposit', [
            'accounts' => $accounts,
            'error' => isset($_GET['error']) ? $_GET['error'] : null
        ]);
    }

    public function depositChecker()
    {
        if (!isset($_POST['amount']) || !isset($_POST['account_id'])) {
            header('Location: /user/account');
            return;
        }

        $amount = floatval($_POST['amount']);
        $account_id = $_POST['account_id'];
        $user_id = $_SESSION['user_id'];

        // Get account and verify it belongs to the user
        $account = $this->accountModel->getAccountById($account_id);

        if (!$account || $account['user_id'] != $user_id) {
            header('Location: /user/account');
            return;
        }

        // Check account status
        $status = $this->accountModel->checkAccountStatus($account_id);
        if ($status === 'inactive') {
            $this->renderClient('deposit', [
                'accounts' => $this->accountModel->getAccountsById($user_id),
                'error' => 'Ce compte est bloqué. Les dépôts ne sont pas autorisés.'
            ]);
            return;
        }

        // Validation checks
        if ($amount <= 0) {
            $this->renderClient('deposit', [
                'account' => $account,
                'error' => 'Le montant doit être supérieur à 0'
            ]);
            return;
        }

        try {
            $this->accountModel->deposit($account_id, $amount, '', $user_id);
            header('Location: /user/account?success=deposit');
        } catch (Exception $e) {
            $this->renderClient('deposit', [
                'account' => $account,
                'error' => $e->getMessage()
            ]);
        }
    }
}
