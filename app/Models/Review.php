<?php

class Review
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getAllReviews()
    {
        $query = "SELECT r.*, u.name as user_name, rm.room_number, k.name as kos_name 
                  FROM reviews r
                  JOIN users u ON r.user_id = u.id
                  JOIN rooms rm ON r.room_id = rm.id
                  JOIN kos k ON rm.kos_id = k.id
                  ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewsByRoomId($room_id)
    {
        $query = "SELECT r.*, u.name as user_name 
                  FROM reviews r
                  JOIN users u ON r.user_id = u.id
                  WHERE r.room_id = :room_id
                  ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':room_id', $room_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewsByUserId($user_id)
    {
        $query = "SELECT r.*, rm.room_number, k.name as kos_name 
                  FROM reviews r
                  JOIN rooms rm ON r.room_id = rm.id
                  JOIN kos k ON rm.kos_id = k.id
                  WHERE r.user_id = :user_id
                  ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReviewById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM reviews WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addReview($data)
    {
        $query = "INSERT INTO reviews (user_id, room_id, rating, comment) 
                  VALUES (:user_id, :room_id, :rating, :comment)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $data['user_id']);
        $stmt->bindParam(':room_id', $data['room_id']);
        $stmt->bindParam(':rating', $data['rating']);
        $stmt->bindParam(':comment', $data['comment']);
        return $stmt->execute();
    }

    public function deleteReview($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM reviews WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getAverageRatingByRoomId($room_id)
    {
        $stmt = $this->conn->prepare("SELECT AVG(rating) as avg_rating FROM reviews WHERE room_id = :room_id");
        $stmt->bindParam(':room_id', $room_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['avg_rating'];
    }
}
