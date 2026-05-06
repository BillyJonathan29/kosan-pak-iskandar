<?php

class BookingController extends Controller {

    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: ' . BASEURL . '/auth');
            exit;
        }

        $userId = $_SESSION['user']['id'];
        $role = $_SESSION['user']['role'];

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

    public function store() {
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

    public function update() {
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

    public function delete($id) {
        $this->model('Booking')->deleteBooking($id);
        header('Location: ' . BASEURL . '/booking');
        exit;
    }

    public function getubah() {
        echo json_encode($this->model('Booking')->getBookingById($_POST['id']));
    }

    // AJAX: ambil harga kamar untuk auto-hitung total di form
    public function getroomprice() {
        $room = $this->model('Room')->getRoomById($_POST['room_id']);
        echo json_encode(['price' => $room ? $room['price'] : 0]);
    }
}
