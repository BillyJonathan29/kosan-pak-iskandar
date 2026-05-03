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

    public function getPaymentByBookingId($booking_id) {
        $stmt = $this->conn->prepare("SELECT * FROM payments WHERE booking_id = :booking_id ORDER BY id DESC LIMIT 1");
        $stmt->bindParam(':booking_id', $booking_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
}
