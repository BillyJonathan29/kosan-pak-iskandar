<?php

class BookingController extends Controller
{

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $role = $_SESSION['user']['role'];

        // Pastikan booking yang telah habis masa sewanya dieksekusi
        $this->model('Booking')->expireBookings();

        if ($role === 'admin') {
            $bookings = $this->model('Booking')->getAllBookings();
        } else {
            $bookings = $this->model('Booking')->getBookingsByUserId($userId);
            $paymentModel = $this->model('Payment');
            foreach ($bookings as &$b) {
                $b['payments'] = $paymentModel->getPaymentsByBookingIdAll($b['id']);
            }
        }

        $data = [
            'title'       => 'Data Booking Saya',
            'breadcrumbs' => [
                ['label' => 'Home',    'url' => BASEURL],
                ['label' => 'Booking', 'url' => '']
            ],
            'bookings'  => $bookings,
            'users'     => $this->model('User')->getAllUsers(),
            'rooms'     => $this->model('Room')->getAllRooms(),
        ];

        if ($role === 'admin') {
            $data['title'] = 'Manajemen Booking';
            $this->view('booking/index', $data);
        } else {
            $this->view('booking/user_index', $data);
        }
    }

    // Tampilkan form perpanjangan sewa (GET) / proses perpanjangan (POST)
    public function extend($id = null)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $bookingId = $_POST['booking_id'];
            $extra = max(0, (int)$_POST['extra_months']);
            if ($extra <= 0) {
                $_SESSION['flash'] = ['pesan' => 'Masukkan jumlah bulan perpanjangan yang valid.', 'tipe' => 'warning'];
                header('Location: ' . BASEURL . '/booking');
                exit;
            }

            $bookingModel = $this->model('Booking');
            $paymentModel = $this->model('Payment');

            $booking = $bookingModel->getBookingById($bookingId);
            if (!$booking || $booking['user_id'] != $_SESSION['user']['id']) {
                $_SESSION['flash'] = ['pesan' => 'Booking tidak ditemukan atau akses ditolak.', 'tipe' => 'danger'];
                header('Location: ' . BASEURL . '/booking');
                exit;
            }

            // Perpanjang durasi
            $newDuration = (int)$booking['duration'] + $extra;
            $updateData = [
                'id' => $bookingId,
                'user_id' => $booking['user_id'],
                'room_id' => $booking['room_id'],
                'booking_date' => $booking['booking_date'],
                'duration' => $newDuration,
                'total_price' => $booking['total_price'] + ($booking['room_price'] * $extra),
                'status' => $booking['status']
            ];

            $bookingModel->updateBooking($updateData);

            // Generate tagihan tambahan mulai dari bulan terakhir + 1
            $existing = $paymentModel->getPaymentsByBookingIdAll($bookingId);
            $lastBilling = 0;
            $lastDue = $booking['booking_date'];
            if (!empty($existing)) {
                $last = end($existing);
                $lastBilling = (int)$last['billing_month'];
                $lastDue = $last['due_date'] ?: $booking['booking_date'];
            }

            for ($i = 1; $i <= $extra; $i++) {
                $billingMonth = $lastBilling + $i;
                $dueDate = date('Y-m-d', strtotime("+" . ($billingMonth - 1) . " months", strtotime($booking['booking_date'])));
                $orderId = 'BOOK-' . $bookingId . '-M' . $billingMonth . '-' . time() . rand(10, 99);

                $paymentData = [
                    'booking_id' => $bookingId,
                    'order_id' => $orderId,
                    'amount' => $booking['room_price'],
                    'billing_month' => $billingMonth,
                    'due_date' => $dueDate
                ];
                $paymentModel->createPaymentMonthly($paymentData);
            }

            $_SESSION['flash'] = ['pesan' => 'Perpanjangan berhasil. Tagihan tambahan telah dibuat.', 'tipe' => 'success'];
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        // GET -> tampilkan form perpanjangan
        $booking = $this->model('Booking')->getBookingById($id);
        if (!$booking) {
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        $data = [
            'title' => 'Perpanjang Sewa',
            'booking' => $booking
        ];
        $this->view('booking/extend', $data);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Hitung total_price otomatis: harga kamar × durasi (bulan)
            $room = $this->model('Room')->getRoomById($_POST['room_id']);
            $_POST['total_price'] = $room ? ($room['price'] * $_POST['duration']) : 0;
            $_POST['status']      = $_POST['status'] ?? 'pending';

            $this->model('Booking')->addBooking($_POST);
            header('Location: ' . BASEURL . '/booking');
            exit;
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recalculate total_price jika room atau durasi berubah
            $room = $this->model('Room')->getRoomById($_POST['room_id']);
            $_POST['total_price'] = $room ? ($room['price'] * $_POST['duration']) : $_POST['total_price'];

            $this->model('Booking')->updateBooking($_POST);

            // Generate monthly payments if status is confirmed
            if ($_POST['status'] === 'confirmed') {
                $paymentModel = $this->model('Payment');
                $booking = $this->model('Booking')->getBookingById($_POST['id']);

                // Cek apakah payment sudah pernah di-generate (untuk menghindari duplicate)
                $existing = $paymentModel->getPaymentsByBookingIdAll($booking['id']);
                if (empty($existing)) {
                    $duration = (int)$booking['duration'];
                    $amount_per_month = $booking['room_price'];

                    for ($i = 1; $i <= $duration; $i++) {
                        $due_date = date('Y-m-d', strtotime("+" . ($i - 1) . " months", strtotime($booking['booking_date'])));
                        $orderId = 'BOOK-' . $booking['id'] . '-M' . $i . '-' . time();

                        $paymentData = [
                            'booking_id' => $booking['id'],
                            'order_id' => $orderId,
                            'amount' => $amount_per_month,
                            'billing_month' => $i,
                            'due_date' => $due_date
                        ];

                        $paymentModel->createPaymentMonthly($paymentData);
                    }
                }
            }

            header('Location: ' . BASEURL . '/booking');
            exit;
        }
    }

    public function delete($id)
    {
        // Only allow admin to hard-delete; normal deletion should free room status as well
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['flash'] = ['pesan' => 'Akses ditolak.', 'tipe' => 'danger'];
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        $this->model('Booking')->deleteBooking($id);
        $_SESSION['flash'] = ['pesan' => 'Booking dihapus.', 'tipe' => 'success'];
        header('Location: ' . BASEURL . '/booking');
        exit;
    }

    public function cancel($id)
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $user = $_SESSION['user'];
        $bookingModel = $this->model('Booking');
        $booking = $bookingModel->getBookingById($id);

        if (!$booking) {
            $_SESSION['flash'] = ['pesan' => 'Booking tidak ditemukan.', 'tipe' => 'warning'];
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        // If user cancels, ensure it belongs to them. Admin can cancel any booking.
        if ($user['role'] !== 'admin' && $booking['user_id'] != $user['id']) {
            $_SESSION['flash'] = ['pesan' => 'Akses ditolak.', 'tipe' => 'danger'];
            header('Location: ' . BASEURL . '/booking');
            exit;
        }

        if ($bookingModel->cancelBooking($id)) {
            $_SESSION['flash'] = ['pesan' => 'Booking berhasil dibatalkan.', 'tipe' => 'success'];
        } else {
            $_SESSION['flash'] = ['pesan' => 'Gagal membatalkan booking.', 'tipe' => 'danger'];
        }
        header('Location: ' . BASEURL . '/booking');
        exit;
    }

    public function getubah()
    {
        echo json_encode($this->model('Booking')->getBookingById($_POST['id']));
    }

    // AJAX: ambil harga kamar untuk auto-hitung total di form
    public function getroomprice()
    {
        $room = $this->model('Room')->getRoomById($_POST['room_id']);
        echo json_encode(['price' => $room ? $room['price'] : 0]);
    }
}
