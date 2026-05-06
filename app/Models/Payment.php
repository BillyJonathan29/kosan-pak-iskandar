<?php

class Payment {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Menyimpan data awal pembayaran (status pending)
     */
    public function createPayment($data) {
        $query = "INSERT INTO payments (booking_id, order_id, snap_token, amount, payment_status, payment_method) 
                  VALUES (:booking_id, :order_id, :snap_token, :amount, 'unpaid', 'midtrans')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $data['booking_id']);
        $stmt->bindParam(':order_id', $data['order_id']);
        $stmt->bindParam(':snap_token', $data['snap_token']);
        $stmt->bindParam(':amount', $data['amount']);
        
        return $stmt->execute();
    }

    /**
     * Menyimpan data tagihan bulanan awal tanpa snap_token
     */
    public function createPaymentMonthly($data) {
        $query = "INSERT INTO payments (booking_id, order_id, amount, payment_status, payment_method, billing_month, due_date) 
                  VALUES (:booking_id, :order_id, :amount, 'unpaid', 'midtrans', :billing_month, :due_date)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':booking_id', $data['booking_id']);
        $stmt->bindParam(':order_id', $data['order_id']);
        $stmt->bindParam(':amount', $data['amount']);
        $stmt->bindParam(':billing_month', $data['billing_month']);
        $stmt->bindParam(':due_date', $data['due_date']);
        
        return $stmt->execute();
    }

    public function updateSnapToken($id, $snap_token) {
        $query = "UPDATE payments SET snap_token = :snap_token WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':snap_token', $snap_token);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getPaymentByBookingId($booking_id) {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE booking_id = :booking_id ORDER BY id DESC LIMIT 1");
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPaymentsByBookingIdAll($booking_id) {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE booking_id = :booking_id ORDER BY billing_month ASC");
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPaymentByOrderId($order_id) {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE order_id = :order_id");
        $stmt->bindParam(':order_id', $order_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePaymentStatus($order_id, $data) {
        $query = "UPDATE payments SET 
                    transaction_id = :transaction_id,
                    payment_method = :payment_method,
                    payment_status = :payment_status";
        
        if ($data['payment_status'] === 'paid') {
            $query .= ", paid_at = :paid_at";
        }

        $query .= " WHERE order_id = :order_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':transaction_id', $data['transaction_id']);
        $stmt->bindParam(':payment_method', $data['payment_method']);
        $stmt->bindParam(':payment_status', $data['payment_status']);
        $stmt->bindParam(':order_id', $order_id);
        
        if ($data['payment_status'] === 'paid') {
            $stmt->bindParam(':paid_at', $data['paid_at']);
        }
        
        return $stmt->execute();
    }

    /**
     * Mengambil semua data pembayaran dengan JOIN ke bookings, users, dan rooms
     * Digunakan oleh Admin untuk memantau seluruh riwayat transaksi
     */
    public function getAllPayments() {
        $query = "SELECT 
                    p.id,
                    p.order_id,
                    p.amount,
                    p.payment_method,
                    p.payment_status,
                    p.paid_at,
                    p.created_at,
                    p.billing_month,
                    p.due_date,
                    u.name   AS tenant_name,
                    u.email  AS tenant_email,
                    r.room_number
                  FROM payments p
                  INNER JOIN bookings b ON p.booking_id = b.id
                  INNER JOIN users    u ON b.user_id    = u.id
                  INNER JOIN rooms    r ON b.room_id    = r.id
                  ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Mengambil satu data pembayaran berdasarkan ID (untuk halaman Detail Transaksi)
     */
    public function getPaymentById($id) {
        $query = "SELECT 
                    p.*,
                    u.name   AS tenant_name,
                    u.email  AS tenant_email,
                    u.phone  AS tenant_phone,
                    r.room_number,
                    b.booking_date,
                    b.duration,
                    b.total_price,
                    b.status AS booking_status
                  FROM payments p
                  INNER JOIN bookings b ON p.booking_id = b.id
                  INNER JOIN users    u ON b.user_id    = u.id
                  INNER JOIN rooms    r ON b.room_id    = r.id
                  WHERE p.id = :id
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
