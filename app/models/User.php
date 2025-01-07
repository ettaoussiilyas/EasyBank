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

        public function insertUser($user){

            $stmt = $this->conn->prepare("INSERT INTO users(name,email,password) values (?,?,?)");
            $result = $stmt->execute([$user['name'], $user['email'], $user['password']]);
            return $result;
        }
    }



?>