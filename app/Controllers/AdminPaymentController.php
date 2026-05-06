<?php

class AdminPaymentController extends Controller {

    /**
     * Guard: pastikan user sudah login dan memiliki role 'admin'.
     * Dipanggil di setiap method yang memerlukan proteksi.
     */
    private function requireAdmin() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        if ($_SESSION['user']['role'] !== 'admin') {
            // Penyewa biasa tidak boleh mengakses halaman ini
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
     *
     * Route: GET /adminpayment   (atau sesuai routing yang dipakai)
     */
    public function index() {
        $this->requireAdmin();

        $paymentModel = $this->model('Payment');
        $payments     = $paymentModel->getAllPayments();

        $data = [
            'title'    => 'Data Pembayaran',
            'breadcrumbs' => [
                ['label' => 'Home',         'url' => BASEURL . '/home'],
                ['label' => 'Pembayaran',   'url' => '']
            ],
            'payments' => $payments
        ];

        $this->view('admin/payments/index', $data);
    }

    /**
     * Menampilkan detail satu transaksi berdasarkan ID (Admin only).
     *
     * Route: GET /adminpayment/detail/{id}
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
            header('Location: ' . BASEURL . '/adminpayment');
            exit;
        }

        $data = [
            'title'    => 'Detail Transaksi',
            'breadcrumbs' => [
                ['label' => 'Home',         'url' => BASEURL . '/home'],
                ['label' => 'Pembayaran',   'url' => BASEURL . '/adminpayment'],
                ['label' => 'Detail',       'url' => '']
            ],
            'payment' => $payment
        ];

        $this->view('admin/payments/detail', $data);
    }
}
