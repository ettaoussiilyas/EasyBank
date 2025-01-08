<?php

    require_once '../app/models/Accounts.php';
    require_once '../app/models/User.php';
    

    class AccountController extends BaseController{

        private $accountModel;
        private $userModel;


        public function __construct(){
            $this->accountModel = new Accounts();
            $this->userModel = new User();
        }

        public function makeWithdrawal(){
            $id = $_POST['id'];
            $amount = $_POST['amount'];
            try {

                $result = $bankAccount->makeWithdrawal($id, $amount);

                if ($result['success']) {
                    echo "Withdrawal successful. New balance: " . $result['new_balance'];
                }
            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }
        }

        public function showAccount(){
            //get account and get user to show balnce of account ...
            $id = $_SESSION['user_id'];
            $accounts = $this->accountModel->getAccountsById($id);
            $user = $this->userModel->getUserById($id);
            $this->renderClient('account',[
                'user' => $user,
                'accounts' => $accounts
            ]);
        }




    }


?>