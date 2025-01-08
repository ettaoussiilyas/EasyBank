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

        public function updateUser($data){
            $stmt = $this->conn->prepare("UPDATE users SET name =?, email =?, password =?, profile_pic=? WHERE id =?");
            $result = $stmt->execute([$data['name'], $data['email'], $data['password'],$data['picture'], $data['id']]);
            return $result;

        }

        public function getStatus($id){

            $stmt = $this->conn->prepare("SELECT status FROM accounts WHERE id =?");
            $stmt->execute([$id]);
            return $stmt->fetch()['status'];
            
        }
    }



?>