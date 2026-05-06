<?php

use Midtrans\Config;
use Midtrans\Transaction;

class TransactionController extends Controller {

    public function __construct() {
        // Set Midtrans configuration
        Config::$serverKey = MIDTRANS_SERVER_KEY;
        Config::$isProduction = MIDTRANS_IS_PRODUCTION;
        Config::$isSanitized = MIDTRANS_IS_SANITIZED;
        Config::$is3ds = MIDTRANS_IS_3DS;
    }

    /**
     * Guard: pastikan user sudah login dan memiliki role 'admin'.
     */
    private function requireAdmin() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash'] = [
                'pesan' => 'Anda tidak memiliki akses ke halaman tersebut.',
                'tipe'  => 'danger'
            ];
            header('Location: ' . BASEURL . '/katalog');
            exit;
        }
    }

    /**
     * Menampilkan daftar seluruh transaksi pembayaran (Admin only).
     * Route: GET /transaction
     */
    public function index() {
        $this->requireAdmin();

        $paymentModel = $this->model('Payment');
        $payments     = $paymentModel->getAllPayments();

        $data = [
            'title'    => 'Data Transaksi',
            'breadcrumbs' => [
                ['label' => 'Home',         'url' => BASEURL . '/home'],
                ['label' => 'Transaksi',     'url' => '']
            ],
            'payments' => $payments
        ];

        $this->view('transaction/index', $data);
    }

    /**
     * Menampilkan detail satu transaksi berdasarkan ID (Admin only).
     * Route: GET /transaction/detail/{id}
     */
    public function detail($id) {
        $this->requireAdmin();

        $paymentModel = $this->model('Payment');
        $payment      = $paymentModel->getPaymentById($id);

        if (!$payment) {
            $_SESSION['flash'] = [
                'pesan' => 'Data transaksi tidak ditemukan.',
                'tipe'  => 'warning'
            ];
            header('Location: ' . BASEURL . '/transaction');
            exit;
        }

        $data = [
            'title'    => 'Detail Transaksi',
            'breadcrumbs' => [
                ['label' => 'Home',         'url' => BASEURL . '/home'],
                ['label' => 'Transaksi',     'url' => BASEURL . '/transaction'],
                ['label' => 'Detail',       'url' => '']
            ],
            'payment' => $payment
        ];

        $this->view('transaction/detail', $data);
    }

    /**
     * Mengecek status transaksi langsung ke API Midtrans (Manual Sync)
     */
    public function checkStatus($id) {
        $this->requireAdmin();

        $paymentModel = $this->model('Payment');
        $payment = $paymentModel->getPaymentById($id);

        if (!$payment) {
            $_SESSION['flash'] = ['pesan' => 'Transaksi tidak ditemukan.', 'tipe' => 'warning'];
            header('Location: ' . BASEURL . '/transaction');
            exit;
        }

        try {
            // Ambil status terbaru dari Midtrans berdasarkan Order ID
            $status = Transaction::status($payment['order_id']);
            
            $transactionStatus = $status->transaction_status;
            $type = $status->payment_type ?? $payment['payment_method'];
            $transaction_id = $status->transaction_id ?? $payment['transaction_id'];
            
            $payment_status = 'pending';
            $paid_at = null;

            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $payment_status = 'paid';
                $paid_at = date('Y-m-d H:i:s');
            } else if ($transactionStatus == 'pending') {
                $payment_status = 'pending';
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $payment_status = ($transactionStatus == 'expire') ? 'expired' : 'failed';
            }

            if ($payment_status !== $payment['payment_status']) {
                $paymentData = [
                    'transaction_id' => $transaction_id,
                    'payment_method' => $type,
                    'payment_status' => $payment_status,
                    'paid_at' => $paid_at
                ];
                
                $paymentModel->updatePaymentStatus($payment['order_id'], $paymentData);

                // Update status booking & kamar jika lunas
                if ($payment_status === 'paid') {
                    // Selalu update kamar jadi occupied jika ada pembayaran lunas
                    $this->model('Katalog')->updateRoomStatusOccupied($payment['room_id']);

                    // Cek apakah semua tagihan sudah lunas
                    $allPayments = $paymentModel->getPaymentsByBookingIdAll($payment['booking_id']);
                    $isAllPaid = true;
                    foreach ($allPayments as $p) {
                        if ($p['payment_status'] !== 'paid') {
                            $isAllPaid = false;
                            break;
                        }
                    }

                    // Hanya set completed jika semua tagihan lunas
                    if ($isAllPaid) {
                        $this->model('Booking')->updateStatus($payment['booking_id'], 'completed');
                    }
                }
                
                $_SESSION['flash'] = ['pesan' => 'Status sinkronisasi berhasil! Status saat ini: ' . strtoupper($payment_status), 'tipe' => 'success'];
            } else {
                $_SESSION['flash'] = ['pesan' => 'Sinkronisasi selesai. Belum ada perubahan status dari Midtrans.', 'tipe' => 'info'];
            }

        } catch (Exception $e) {
            // Jika transaksi belum ada di Midtrans (belum dipilih metodenya)
            if (strpos($e->getMessage(), '404') !== false) {
                $_SESSION['flash'] = ['pesan' => 'Transaksi belum diproses atau dibatalkan oleh user.', 'tipe' => 'warning'];
            } else {
                $_SESSION['flash'] = ['pesan' => 'Gagal sinkronisasi ke Midtrans: ' . $e->getMessage(), 'tipe' => 'danger'];
            }
        }

        header('Location: ' . BASEURL . '/transaction/detail/' . $id);
        exit;
    }
}
