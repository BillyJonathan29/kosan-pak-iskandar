<?php

class AdminPaymentController extends Controller {
    public function __construct()
    {
        $this->requireRole('admin');
    }

    /**
     * Menampilkan daftar seluruh transaksi pembayaran (Admin only).
     *
     * Route: GET /adminpayment   (atau sesuai routing yang dipakai)
     */
    public function index() {
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
