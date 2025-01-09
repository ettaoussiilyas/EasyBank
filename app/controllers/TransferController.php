<?php

    // require_once '../core/BaseController.php';

    require_once '../app/models/User.php';
    require_once '../app/models/Accounts.php';
    require_once '../app/models/Transfer.php';

    class TransferController extends BaseController {

        private $userModel;
        private $accountModel;
        private $transferModel;

        public function __construct(){
            $this->userModel = new User();
            $this->accountModel = new Accounts();
            $this->transferModel = new Transfer();
        }

        public function showTransfer(){
            $user_id = $_SESSION['user_id'];    
            $accounts = $this->accountModel->getAccountsById($user_id);
            $transfers = $this->transferModel->getTransfersById($user_id);
            $this->renderClient('transfer', ['accounts' => $accounts, 'transfers' => $transfers]);
        }





    }



?>