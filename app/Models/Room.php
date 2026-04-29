<?php

class Room {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllRooms() {
        $query = "SELECT rooms.*, kos.name as kos_name 
                  FROM rooms 
                  JOIN kos ON rooms.kos_id = kos.id 
                  ORDER BY rooms.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM rooms WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addRoom($data) {
        $query = "INSERT INTO rooms (kos_id, room_number, price, status, description, image) 
                  VALUES (:kos_id, :room_number, :price, :status, :description, :image)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':kos_id', $data['kos_id']);
        $stmt->bindParam(':room_number', $data['room_number']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':image', $data['image']);
        
        return $stmt->execute();
    }

    public function updateRoom($data) {
        $query = "UPDATE rooms SET 
                    kos_id = :kos_id, 
                    room_number = :room_number, 
                    price = :price, 
                    status = :status, 
                    description = :description, 
                    image = :image 
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':kos_id', $data['kos_id']);
        $stmt->bindParam(':room_number', $data['room_number']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':id', $data['id']);
        
        return $stmt->execute();
    }

    public function deleteRoom($id) {
        // Ambil data dulu untuk hapus gambarnya
        $room = $this->getRoomById($id);
        
        $stmt = $this->conn->prepare("DELETE FROM rooms WHERE id = :id");
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute()) {
            return $room; // Kembalikan data room untuk hapus file di controller
        }
        return false;
    }

    public function countRooms() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM rooms");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function countByStatus($status) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM rooms WHERE status = :status");
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getRecentRooms($limit = 5) {
        $query = "SELECT rooms.*, kos.name as kos_name 
                  FROM rooms 
                  JOIN kos ON rooms.kos_id = kos.id 
                  ORDER BY rooms.created_at DESC 
                  LIMIT :limit";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
