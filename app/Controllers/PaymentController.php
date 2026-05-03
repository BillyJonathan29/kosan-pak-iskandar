<?php

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller {

    public function __construct() {
        // Set Midtrans configuration
        Config::$serverKey = MIDTRANS_SERVER_KEY;
        Config::$isProduction = MIDTRANS_IS_PRODUCTION;
        Config::$isSanitized = MIDTRANS_IS_SANITIZED;
        Config::$is3ds = MIDTRANS_IS_3DS;
    }

    public function pay($bookingId) {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $paymentModel = $this->model('Payment');
        $bookingModel = $this->model('Booking');
        
        $booking = $bookingModel->getBookingById($bookingId);
        
        // 1. Validasi Akses: Harus milik user ybs, status confirmed, dan belum dibayar
        if (!$booking || $booking['user_id'] != $_SESSION['user']['id']) {
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        if ($booking['status'] !== 'confirmed') {
            $_SESSION['flash'] = ['pesan' => 'Booking Anda belum dikonfirmasi oleh Admin.', 'tipe' => 'warning'];
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        $payment = $paymentModel->getPaymentByBookingId($bookingId);
        
        if ($payment && $payment['payment_status'] === 'paid') {
            $_SESSION['flash'] = ['pesan' => 'Booking ini sudah dibayar.', 'tipe' => 'info'];
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        // 2. Buat Pembayaran jika belum ada
        if (!$payment) {
            $orderId = 'BOOK-' . $bookingId . '-' . time();
            $amount = $booking['total_price'];

            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int)$amount,
                ],
                'customer_details' => [
                    'first_name' => $_SESSION['user']['name'],
                    'email' => $_SESSION['user']['email'],
                ],
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                
                $paymentData = [
                    'booking_id' => $bookingId,
                    'order_id' => $orderId,
                    'snap_token' => $snapToken,
                    'amount' => $amount
                ];
                
                $paymentModel->createPayment($paymentData);
                $payment = $paymentModel->getPaymentByOrderId($orderId);
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }
        }

        // 3. Ambil data fasilitas kamar
        $facilities = $this->model('Katalog')->getRoomFacilities($booking['room_id']);

        $data = [
            'title' => 'Checkout Pembayaran',
            'booking' => $booking,
            'payment' => $payment,
            'facilities' => $facilities,
            'clientKey' => MIDTRANS_CLIENT_KEY
        ];

        $this->view('payment/pay', $data);
    }

    public function notification() {
        try {
            $notif = new Notification();
        } catch (Exception $e) {
            exit;
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $payment_status = 'pending';
        $paid_at = null;

        if ($transaction == 'settlement') {
            $payment_status = 'paid';
            $paid_at = date('Y-m-d H:i:s');
        } else if ($transaction == 'pending') {
            $payment_status = 'pending';
        } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
            $payment_status = ($transaction == 'expire') ? 'expired' : 'failed';
        }

        $paymentModel = $this->model('Payment');
        $paymentData = [
            'transaction_id' => $notif->transaction_id,
            'payment_method' => $notif->payment_type,
            'payment_status' => $payment_status,
            'paid_at' => $paid_at
        ];

        $paymentModel->updatePaymentStatus($order_id, $paymentData);

        // Jika berhasil, update juga status booking dan status kamar
        if ($payment_status === 'paid') {
            $payment = $paymentModel->getPaymentByOrderId($order_id);
            if ($payment) {
                $booking = $this->model('Booking')->getBookingById($payment['booking_id']);
                if ($booking) {
                    $this->model('Booking')->updateStatus($payment['booking_id'], 'completed');
                    $this->model('Katalog')->updateRoomStatusOccupied($booking['room_id']);
                }
            }
        }
    }

    public function finish() {
        $_SESSION['flash'] = [
            'pesan' => 'Pembayaran sedang diproses atau berhasil!',
            'tipe' => 'success'
        ];
        header('Location: ' . BASEURL . '/booking');
        exit;
    }

    public function unfinish() {
        $_SESSION['flash'] = [
            'pesan' => 'Pembayaran belum diselesaikan.',
            'tipe' => 'warning'
        ];
        header('Location: ' . BASEURL . '/booking');
        exit;
    }

    public function error() {
        $_SESSION['flash'] = [
            'pesan' => 'Terjadi kesalahan saat pembayaran.',
            'tipe' => 'danger'
        ];
        header('Location: ' . BASEURL . '/booking');
        exit;
    }
}
