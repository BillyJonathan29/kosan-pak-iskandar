<?php

class Kos {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllKos() {
        $stmt = $this->conn->prepare("SELECT * FROM kos ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKosById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM kos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addKos($data) {
        $query = "INSERT INTO kos (name, address, description, phone) 
                  VALUES (:name, :address, :description, :phone)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':phone', $data['phone']);
        
        return $stmt->execute();
    }

    public function updateKos($data) {
        $query = "UPDATE kos SET 
                    name = :name, 
                    address = :address, 
                    description = :description, 
                    phone = :phone 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':address', $data['address']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':id', $data['id']);
        
        return $stmt->execute();
    }

    public function deleteKos($id) {
        $stmt = $this->conn->prepare("DELETE FROM kos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function countKos() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM kos");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
