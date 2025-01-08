<?php

class User extends Db
{



    public function __construct()
    {
        parent::__construct();
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

    public function createUser($name, $email, $profile_pic = null)
    {

        $password = bin2hex(random_bytes(6));

        $sql = "INSERT INTO users (name, email, password, profile_pic) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            $name,
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $profile_pic
        ]);

        return [
            'success' => $result,
            'password' => $password
        ];
    }

    public function updateUser($id, $name, $email, $password, $profile_pic = null)
    {
        $sql = "UPDATE users SET name = ?, email = ?, password = ?, profile_pic = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $name,
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $profile_pic,
            $id
        ]);
    }
}
