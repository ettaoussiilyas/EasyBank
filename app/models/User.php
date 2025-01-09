<?php

class User extends Db
{



    public function __construct()
    {
        parent::__construct();
    }

        public function getUserById($id){
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
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

    

    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users WHERE id != 1 ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function createUser($name, $email, $password, $profile_pic = null)
    {
        try {
            $sql = "INSERT INTO users (name, email, password, profile_pic, created_at) VALUES (?, ?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([
                $name,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $profile_pic
            ]);

            if ($result) {
                return $this->conn->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }

    public function updateUsers($id, $name, $email, $password = null, $profile_pic = null) {
        if ($password) {
            $sql = "UPDATE users SET name = ?, email = ?, password = ?, profile_pic = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $name,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $profile_pic,
                $id
            ]);
        } else {
            $sql = "UPDATE users SET name = ?, email = ?, profile_pic = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $name,
                $email,
                $profile_pic,
                $id
            ]);
        }
    }

     public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
