<?php

class User {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT * FROM users ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($data) {
        $query = "INSERT INTO users (name, email, password, phone, role, profile_image) 
                  VALUES (:name, :email, :password, :phone, :role, :profile_image)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        // Password harus di-hash sebelum masuk ke database, anggap sudah di-hash di controller atau hash disini
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':profile_image', $data['profile_image']);
        
        return $stmt->execute();
    }

    public function updateUser($data) {
        $query = "UPDATE users SET 
                    name = :name, 
                    email = :email, 
                    phone = :phone, 
                    role = :role";
        
        if(!empty($data['password'])) {
            $query .= ", password = :password";
        }

        if(isset($data['profile_image'])) {
            $query .= ", profile_image = :profile_image";
        }

        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':id', $data['id']);
        
        if(!empty($data['password'])) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $password);
        }

        if(isset($data['profile_image'])) {
            $stmt->bindParam(':profile_image', $data['profile_image']);
        }
        
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
