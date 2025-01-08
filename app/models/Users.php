<?php
require_once(__DIR__ . '/../config/db.php');

class Users extends Db {
    
    public function __construct() {
        parent::__construct();
    }

    public function getAllUsers() {
        $stmt = $this->conn->query("
            SELECT 
                users.id,
                users.name,
                users.email,
                users.profile_pic,
                users.created_at
            FROM users 
            WHERE users.id != 1
            ORDER BY users.created_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $email, $password, $profile_pic = null) {
        $sql = "INSERT INTO users (name, email, password, profile_pic) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $profile_pic]);
    }

    public function updateUser($id, $name, $email, $profile_pic = null) {
        $sql = "UPDATE users SET name = ?, email = ?, profile_pic = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $email, $profile_pic, $id]);
    }

    // public function deleteUser($id) {
    //     $sql = "DELETE FROM users WHERE id = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     return $stmt->execute([$id]);
    // }

    // public function getUserById($id) {
    //     $sql = "SELECT * FROM users WHERE id = ?";
    //     $stmt = $this->conn->prepare($sql);
    //     $stmt->execute([$id]);
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }
} 