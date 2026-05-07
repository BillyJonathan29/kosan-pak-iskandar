<?php

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{

    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = MIDTRANS_SERVER_KEY;
        Config::$isProduction = MIDTRANS_IS_PRODUCTION;
        Config::$isSanitized = MIDTRANS_IS_SANITIZED;
        Config::$is3ds = MIDTRANS_IS_3DS;
    }

    public function pay($paymentId)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $paymentModel = $this->model('Payment');
        $bookingModel = $this->model('Booking');

        $payment = $paymentModel->getPaymentById($paymentId);

        if (!$payment) {
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        $booking = $bookingModel->getBookingById($payment['booking_id']);

        // 1. Validasi Akses: Harus milik user ybs dan status confirmed
        if (!$booking || $booking['user_id'] != $_SESSION['user']['id']) {
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        if ($booking['status'] !== 'confirmed') {
            $_SESSION['flash'] = ['pesan' => 'Booking Anda belum dikonfirmasi oleh Admin.', 'tipe' => 'warning'];
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        if ($payment['payment_status'] === 'paid') {
            $_SESSION['flash'] = ['pesan' => 'Tagihan ini sudah dibayar.', 'tipe' => 'info'];
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        // 2. Generate Snap Token jika belum ada
        if (empty($payment['snap_token'])) {
            $params = [
                'transaction_details' => [
                    'order_id' => $payment['order_id'],
                    'gross_amount' => (int)$payment['amount'],
                ],
                'customer_details' => [
                    'first_name' => $_SESSION['user']['name'],
                    'email' => $_SESSION['user']['email'],
                ],
                'callbacks' => [
                    'finish' => BASEURL . '/payment/finish'
                ]
            ];

            try {
                $snapToken = Snap::getSnapToken($params);
                $paymentModel->updateSnapToken($payment['id'], $snapToken);
                $payment['snap_token'] = $snapToken;
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

    public function notification()
    {
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
        }
    }

    public function finish()
    {
        // If order_id is present, try to immediately verify transaction status
        $order_id = $_GET['order_id'] ?? null;
        if ($order_id) {
            try {
                $resp = \Midtrans\Transaction::status($order_id);
            } catch (Exception $e) {
                $_SESSION['flash'] = ['pesan' => 'Pembayaran berhasil. Menunggu konfirmasi.', 'tipe' => 'success'];
                header('Location: ' . BASEURL . '/booking');
                exit;
            }

            $transaction = $resp->transaction_status ?? ($resp['transaction_status'] ?? null);
            $fraud = $resp->fraud_status ?? ($resp['fraud_status'] ?? null);

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
                'transaction_id' => $resp->transaction_id ?? ($resp['transaction_id'] ?? null),
                'payment_method' => $resp->payment_type ?? ($resp['payment_type'] ?? null),
                'payment_status' => $payment_status,
                'paid_at' => $paid_at
            ];

            $paymentModel->updatePaymentStatus($order_id, $paymentData);

            // If paid, perform the same follow-up actions as in notification
            if ($payment_status === 'paid') {
                $payment = $paymentModel->getPaymentByOrderId($order_id);
                if ($payment) {
                    $this->model('Katalog')->updateRoomStatusOccupied($payment['room_id']);

                    $allPayments = $paymentModel->getPaymentsByBookingIdAll($payment['booking_id']);
                    $isAllPaid = true;
                    foreach ($allPayments as $p) {
                        if ($p['payment_status'] !== 'paid') {
                            $isAllPaid = false;
                            break;
                        }
                    }

                    if ($isAllPaid) {
                        $this->model('Booking')->updateStatus($payment['booking_id'], 'completed');
                    }
                }
            }

            $_SESSION['flash'] = ['pesan' => 'Pembayaran berhasil diproses.', 'tipe' => 'success'];
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        // Fallback if no order_id provided
        $_SESSION['flash'] = [
            'pesan' => 'Pembayaran sedang diproses atau berhasil!',
            'tipe' => 'success'
        ];
        header('Location: ' . BASEURL . '/booking');
        exit;
    }

    public function invoice($paymentId = null)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        if (!$paymentId) {
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        $paymentModel = $this->model('Payment');
        $payment = $paymentModel->getPaymentById($paymentId);

        if (!$payment || $payment['tenant_email'] !== $_SESSION['user']['email']) {
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        // Gunakan Dompdf untuk render PDF
        require_once __DIR__ . '/../../vendor/autoload.php';
        $options = new \Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new \Dompdf\Dompdf($options);

        // Siapkan HTML invoice (gunakan view sederhana)
        ob_start();
        $invoiceData = $payment;
        require __DIR__ . '/../../views/payment/invoice_template.php';
        $html = ob_get_clean();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'kwitansi-' . $payment['order_id'] . '.pdf';
        $dompdf->stream($filename, ['Attachment' => 1]);
        exit;
    }

    public function unfinish()
    {
        $_SESSION['flash'] = [
            'pesan' => 'Pembayaran belum diselesaikan.',
            'tipe' => 'warning'
        ];
        header('Location: ' . BASEURL . '/booking');
        exit;
    }

    public function error()
    {
        $_SESSION['flash'] = [
            'pesan' => 'Terjadi kesalahan saat pembayaran.',
            'tipe' => 'danger'
        ];
        header('Location: ' . BASEURL . '/booking');
        exit;
    }
}
