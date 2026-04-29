<?php

class BookingController extends Controller {

    public function index() {
        $data = [
            'title'       => 'Manajemen Booking',
            'breadcrumbs' => [
                ['label' => 'Home',    'url' => BASEURL],
                ['label' => 'Booking', 'url' => '']
            ],
            'bookings'  => $this->model('Booking')->getAllBookings(),
            'users'     => $this->model('User')->getAllUsers(),
            'rooms'     => $this->model('Room')->getAllRooms(),
        ];

        $this->view('booking/index', $data);
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
