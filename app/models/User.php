<?php

    class User extends Db {
        


        public function __construct(){
            parent::__construct();
        }

        public function getUserByEmail($email){
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            return $stmt->fetch();
        }

        public function getAllUsers(){
            $sql = "SELECT * FROM users";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }



?>