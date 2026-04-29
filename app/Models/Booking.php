<?php

class Booking {
    private $db;
    private $conn;

    public function __construct() {
        $this->db   = new Database();
        $this->conn = $this->db->getConnection();
    }

    // ─── READ ────────────────────────────────────────────────────────────────

    public function getAllBookings() {
        $query = "SELECT b.*,
                         u.name  AS user_name,
                         u.email AS user_email,
                         u.phone AS user_phone,
                         r.room_number,
                         k.name  AS kos_name
                  FROM bookings b
                  JOIN users u ON b.user_id = u.id
                  JOIN rooms  r ON b.room_id  = r.id
                  JOIN kos    k ON r.kos_id   = k.id
                  ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBookingById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM bookings WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ─── CREATE ──────────────────────────────────────────────────────────────

    public function addBooking($data) {
        $query = "INSERT INTO bookings
                    (user_id, room_id, booking_date, duration, total_price, status)
                  VALUES
                    (:user_id, :room_id, :booking_date, :duration, :total_price, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id',      $data['user_id']);
        $stmt->bindParam(':room_id',      $data['room_id']);
        $stmt->bindParam(':booking_date', $data['booking_date']);
        $stmt->bindParam(':duration',     $data['duration']);
        $stmt->bindParam(':total_price',  $data['total_price']);
        $stmt->bindParam(':status',       $data['status']);
        return $stmt->execute();
    }

    // ─── UPDATE ──────────────────────────────────────────────────────────────

    public function updateBooking($data) {
        $query = "UPDATE bookings SET
                    user_id      = :user_id,
                    room_id      = :room_id,
                    booking_date = :booking_date,
                    duration     = :duration,
                    total_price  = :total_price,
                    status       = :status
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id',      $data['user_id']);
        $stmt->bindParam(':room_id',      $data['room_id']);
        $stmt->bindParam(':booking_date', $data['booking_date']);
        $stmt->bindParam(':duration',     $data['duration']);
        $stmt->bindParam(':total_price',  $data['total_price']);
        $stmt->bindParam(':status',       $data['status']);
        $stmt->bindParam(':id',           $data['id']);
        return $stmt->execute();
    }

    // ─── UPDATE STATUS ONLY ──────────────────────────────────────────────────

    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE bookings SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id',     $id);
        return $stmt->execute();
    }

    // ─── DELETE ──────────────────────────────────────────────────────────────

    public function deleteBooking($id) {
        $stmt = $this->conn->prepare("DELETE FROM bookings WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // ─── STATS (untuk dashboard) ─────────────────────────────────────────────

    public function countBookings() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM bookings");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function countByStatus($status) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM bookings WHERE status = :status");
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
