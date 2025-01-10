<?php

class Transfer extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTransfersById($user_id){
        $sql = "SELECT * FROM transactions inner join accounts on transactions.account_id = accounts.id WHERE accounts.user_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll();
    }
}

?>