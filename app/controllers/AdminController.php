<?php
require_once(__DIR__ . '/../models/Accounts.php');


class AdminController extends BaseController
{
    private $AccountsModel;

    public function __construct()
    {
        $this->AccountsModel = new Accounts();
    }
    public function index()
    {
        $accounts = $this->AccountsModel->getAllAccounts();
        $this->renderAdmin('index', ["" => $accounts]);
    }
}
