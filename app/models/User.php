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

    public function createUser($name, $email, $password, $profile_pic = null, $role = 'user')
    {
        $sql = "INSERT INTO users (name, email, password, profile_pic, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            $name,
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $profile_pic,
            $role
        ]);

        if ($result) {
            return [
                'success' => true,
                'user_id' => $this->conn->lastInsertId(),
                'password' => $password
            ];
        }
        return ['success' => false];
    }

    public function updateUsers($id, $name, $email, $password = null, $profile_pic = null, $role = 'user') {
        if ($password) {
            $sql = "UPDATE users SET name = ?, email = ?, password = ?, profile_pic = ?, role = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $name,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $profile_pic,
                $role,
                $id
            ]);
        } else {
            $sql = "UPDATE users SET name = ?, email = ?, profile_pic = ?, role = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                $name,
                $email,
                $profile_pic,
                $role,
                $id
            ]);
        }
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function searchUsers($term) {
        $term = "%$term%";
        $sql = "SELECT id, name, email, profile_pic, created_at 
                FROM users 
                WHERE id != 1 
                AND (name LIKE ? OR email LIKE ?)
                ORDER BY created_at DESC";
                
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$term, $term]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
