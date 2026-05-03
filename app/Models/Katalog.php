<?php
// Model untuk sisi User (Pencari Kos)
// Query ringan tanpa overhead admin

class Katalog {
    private $db;
    private $conn;

    public function __construct() {
        $this->db   = new Database();
        $this->conn = $this->db->getConnection();
    }

    // ─── Ambil semua kamar dengan status 'available' ──────────────────────────
    public function getAvailableRooms() {
        $query = "SELECT r.*, k.name AS kos_name, k.address AS kos_address
                  FROM rooms r
                  JOIN kos k ON r.kos_id = k.id
                  WHERE r.status = 'available'
                  ORDER BY r.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─── Ambil detail 1 kamar berdasarkan ID ──────────────────────────────────
    public function getRoomDetail($id) {
        $query = "SELECT r.*, k.name AS kos_name, k.address AS kos_address,
                         k.phone AS kos_phone, k.description AS kos_description
                  FROM rooms r
                  JOIN kos k ON r.kos_id = k.id
                  WHERE r.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ─── Ambil fasilitas sebuah kamar via pivot room_facilities ───────────────
    public function getRoomFacilities($room_id) {
        $query = "SELECT f.facility_name, f.icon
                  FROM room_facilities rf
                  JOIN facilities f ON rf.facility_id = f.id
                  WHERE rf.room_id = :room_id
                  ORDER BY f.facility_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ─── Proses booking: INSERT ke bookings ───────────────────────────────────
    public function createBooking($data) {
        $query = "INSERT INTO bookings
                    (user_id, room_id, booking_date, duration, total_price, status)
                  VALUES
                    (:user_id, :room_id, :booking_date, :duration, :total_price, 'pending')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id',      $data['user_id'],      PDO::PARAM_INT);
        $stmt->bindParam(':room_id',      $data['room_id'],      PDO::PARAM_INT);
        $stmt->bindParam(':booking_date', $data['booking_date']);
        $stmt->bindParam(':duration',     $data['duration'],     PDO::PARAM_INT);
        $stmt->bindParam(':total_price',  $data['total_price']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // ─── UPDATE status kamar menjadi 'booked' setelah booking berhasil ────────
    public function updateRoomStatusBooked($room_id) {
        $stmt = $this->conn->prepare(
            "UPDATE rooms SET status = 'booked' WHERE id = :id"
        );
        $stmt->bindParam(':id', $room_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function updateRoomStatusOccupied($room_id) {
        $stmt = $this->conn->prepare(
            "UPDATE rooms SET status = 'occupied' WHERE id = :id"
        );
        $stmt->bindParam(':id', $room_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // ─── Ambil riwayat booking milik 1 user ───────────────────────────────────
    public function getUserBookings($user_id) {
        $query = "SELECT b.*, r.room_number, r.image, k.name AS kos_name
                  FROM bookings b
                  JOIN rooms r ON b.room_id = r.id
                  JOIN kos   k ON r.kos_id  = k.id
                  WHERE b.user_id = :user_id
                  ORDER BY b.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
